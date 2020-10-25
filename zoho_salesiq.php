<?php

/**
 * https://developers.whmcs.com/addon-modules/configuration/
 */
function zoho_salesiq_config() {
    return [
        "name"          => "Zoho Sales IQ",
        "description"   => "This module adds Zoho SalesIQ Widget to your client area.",
        "version"       => "1.0",
        "author"        => "Lightning IP",
        "fields"        => [
            "option1" => [
                "FriendlyName"  => "SalesIQ Widget Code",
                "Type"          => "text",
                "Size"          => "25",
                "Description"   => "Enter just the salesiq widget code",
                "Default"       => "Example"
            ]
        ]
    ];
}