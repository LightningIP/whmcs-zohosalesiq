<?php

namespace WHMCS\Module\Addon\zoho_salesiq;
use WHMCS\Database\Capsule as DB;
use \WHMCS\Authentication\CurrentUser;

class SalesIQ {

    const MODULE_NAME = 'zoho_salesiq';

    /**
     * Get widget code from the database
     */
    private static function getWidgetCode($vars = NULL) {
        return DB::table('tbladdonmodules')
            ->where([
                ['module',  '=', self::MODULE_NAME],
                ['setting', '=', 'option1'],
            ])
            ->select('value')
            ->first()
            ->value;
    }

    /**
     * https://developers.whmcs.com/hooks-reference/output/#clientareafooteroutput
     */
    public static function ClientAreaFooterOutput($vars) {
        $currentUser = new CurrentUser;
        try {
            $code = self::getWidgetCode();
            $isAdminUser = false; //($currentUser->isAuthenticatedAdmin() || $currentUser->isMasqueradingAdmin());
            if (!empty($code) && $currentUser->isAuthenticatedUser() && !$isAdminUser ) {
                $html = '<script type="text/javascript">';
                $html .= '  var $zoho = $zoho || {};';
                $html .= '  $zoho.salesiq = $zoho.salesiq || {';
                $html .= '      widgetcode:"'.$code.'",';
                $html .= '      values:{},';
                $html .= '      ready: function(){';
                $html .= '          $zoho.salesiq.visitor.name("'. $currentUser->user()->fullName .'");';
                $html .= '          $zoho.salesiq.visitor.email("'. $currentUser->user()->email .'");';
                $html .= '          $zoho.salesiq.visitor.contactnumber("'. $currentUser->client()->phonenumber .'");';
                if ($currentUser->client()->companyname) {
                    $html .= '          $zoho.salesiq.visitor.info({"Company" : "'.$currentUser->client()->companyname.'",});';
                }
                $html .= '      }';
                $html .= '  };';
                $html .= '</script>';
                $html .= '<script type="text/javascript" id="zsiqscript" defer src="https://salesiq.zoho.com/widget"></script>';
                $html .= '<div id="zsiqwidget"></div>';
                return $html;
            }
        } catch (\Exception $e) {
            logActivity(self::MODULE_NAME . ": {$e->getMessage}", 0);
            return $e->getMessage();
        }
    }

}