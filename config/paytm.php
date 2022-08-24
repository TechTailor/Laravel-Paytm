<?php

return [

    /*
    |---------------------------------------------------------------------------------
    | Paytm Payment Gateway (PG)
    |---------------------------------------------------------------------------------
    |
    | Use Paytm Payment gateway solution in your App or website to simplify payment 
    | for your customers. Your customers can choose to pay from any credit/debit card, 
    | UPI, Netbanking, Paytm Wallet and EMI.
    |
    |---------------------------------------------------------------------------------
    | Read more: https://business.paytm.com/docs/js-checkout?ref=jsCheckoutDoc
    |---------------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Use the "testing" environment during development and local deployments.
    | You can use Test Instruments provided by PayTM to test your implementation.
    | Test Instruments: https://business.paytm.com/docs/test-instruments/testing-integration/
    |
    | Use the "production" environment when deploying your application.
    |
    */
    'environment' => env('PAYTM_ENV', 'testing'),

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | PayTM provides two seperate endpoints/url for testing and production
    | environments respectively.
    | 
    | More details: https://business.paytm.com/docs/jscheckout-test-go-live
    |
    */
    'url' => [
        'testing' => 'https://securegw-stage.paytm.in', // DO NOT CHANGE
        'production' => 'https://securegw.paytm.in', // DO NOT CHANGE
    ],

    /*
    |--------------------------------------------------------------------------
    | CALLBACK URL
    |--------------------------------------------------------------------------
    |
    | A callback url is required to tell the Paytm PG where to redirect the user
    | once payment process is completed. You can also setup a general callback
    | url in the Paytm Business Dashboard. You can also pass callback: false
    | from the JS call to receive and handle callback data in-page without refresh.
    | 
    | More details: https://business.paytm.com/docs/jscheckout-verify-payment?ref=jsCheckoutdoc
    |
    */
    'callback_url' => env('PAYTM_CALLBACK_URL'),
    
    /*
    |--------------------------------------------------------------------------
    | MARCHANT CREDENTIALS
    |--------------------------------------------------------------------------
    |
    | Merchant ID & Merchant Key can be obtained from the PayTM Business 
    | Dashboard. Beaware not to share these credentials with anyone.
    |
    | Website must be set to "WEBSTAGING" for the testing environment and 
    | set to "DEFAULT" for the production environment.
    | 
    | PayTM Business Dashboard: https://dashboard.paytm.com/next/apikeys
    |
    */
    'merchant' => [
        'id' => env('PAYTM_MERCHANT_ID'),
        'key' => env('PAYTM_MERCHANT_KEY'),
        'website' => env('PAYTM_WEBSITE', 'WEBSTAGING'), // WEBSTAGING or DEFAULT
    ],

    /*
    |--------------------------------------------------------------------------
    | UNIQUE ORDER ID PREFIX
    |--------------------------------------------------------------------------
    |
    | This is a unique prefix that you can add to the Order Id's when 
    | generating the transaction token for the Paytm PG.
    | 
    | Ex: "PAYTM_BLINK_" will generate id as "PAYTM_BLINK_212414589",
    | "PAYTM_ORDERID_" will generate id as "PAYTM_ORDERID_121154589", etc.
    |
    */
    'order_id_prefix' => env('PAYTM_ORDER_ID_PREFIX', 'PAYTM_BLINK_'),
];
