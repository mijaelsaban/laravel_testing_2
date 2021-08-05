<?php

namespace App\Libraries\Paypal;

use PayPalCheckoutSdk\Core\PayPalEnvironment;

class ProductionEnvironment extends PayPalEnvironment
{
    public function __construct($clientId, $clientSecret)
    {
        parent::__construct($clientId, $clientSecret);
    }

    public function baseUrl()
    {
        return "https://api-m.paypal.com/v1/reporting/transactions";
    }
}
