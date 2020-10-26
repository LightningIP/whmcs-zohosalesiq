<?php

use WHMCS\Module\Addon\zoho_salesiq\SalesIQ;

/**
 * 
 */
add_hook('ClientAreaFooterOutput', 1, function($vars) {
    return SalesIQ::ClientAreaFooterOutput($vars);
});