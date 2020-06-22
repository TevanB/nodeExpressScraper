<?php

namespace App\Http\Controllers\PaypalRelated;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
     */
    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "AU_f6op8E-Ijt-00jtij_n1JguJt66CYxoihZPNJM-MdGiD9qQU5s1wF2S_oD5ksJcrwe5-b6S7PPE25";
        $clientSecret = getenv("CLIENT_SECRET") ?: "ELCvghzLHoRb3nKGl0-aYb99lo2seN6TvCtOKsSKfcp82R-nh_5262VU2n8nu8w19pFAYtEvoIjWL7NL";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
