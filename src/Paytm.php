<?php

namespace TechTailor\Paytm;

use paytm\paytmchecksum\PaytmChecksum;

class Paytm
{
    /**
     * Generate a transaction token for the PayTM PG.
     *
     * @param float $amount
     * @param array $customer
     *
     * @return array $result
     */
    public function getTransactionToken($amount, $customer)
    {
        // Generate a unique order id using the order_id_prefix.
        $newOrderId = config('paytm.order_id_prefix').time();

        // Prepare the JSON string for request.
        $paytmParams['body'] = [
            'requestType' 	=> 'Payment', // Request Type
            'mid' 			      => config('paytm.merchant.id'), // Paytm Merchant ID
            'websiteName' 	=> config('paytm.website'), // Paytm Website
            'orderId' 		   => $newOrderId,
            'callbackUrl' 	=> config('paytm.callback_url'), // Callback url for processing responses from paytm
            'txnAmount' 	  => [
                'value'    => $amount,
                'currency' => 'INR', // Only INR Supported
            ],
            'userInfo' 		=> [
                'custId'    => $customer['custId'], // Mandatory
                'mobile'    => $customer['mobile'] ?? null, // Optional
                'email'     => $customer['email'] ?? null, // Optional
                'firstName' => $customer['firstName'] ?? null, // Optional
                'lastName'  => $customer['lastName'] ?? null, // Optional
            ],
        ];

        // Generate a unique signature using PaytmChecksumhash.
        $generateSignature = PaytmChecksum::generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), config('paytm.merchant.key'));

        // Add the generated signature to the parameters for posting.
        $paytmParams['head'] = ['signature' => $generateSignature];

        // Set the api endpoint for the local, testing or staging environment
        if (config('paytm.environment') == 'testing') {
            $url = config('paytm.url.testing').'/theia/api/v1/initiateTransaction?mid='.config('paytm.merchant.id').'&orderId='.$newOrderId;
        }

        // Set the api endpoint for the production environment
        elseif (config('paytm.environment' == 'production')) {
            $url = config('paytm.url.production').'/theia/api/v1/initiateTransaction?mid='.config('paytm.merchant.id').'&orderId='.$newOrderId;
        }

        // Send an api request to PayTM.
        $response = $this->getcURLRequest($url, $paytmParams);

        // Evaluate the response and return appropriate result.
        if (!empty($response['body']['resultInfo']['resultStatus']) && $response['body']['resultInfo']['resultStatus'] == 'S') {
            $result = ['success' => true, 'orderId' => $newOrderId, 'txnToken' => $response['body']['txnToken'], 'amount' => $amount, 'message' => $response['body']['resultInfo']['resultMsg']];
        } else {
            $result = ['success' => false, 'orderId' => $newOrderId, 'txnToken' => '', 'amount' => $amount, 'message' => $response['body']['resultInfo']['resultMsg']];
        }

        // Return result array.
        return $result;
    }

    /**
     * Verify the status of a transaction/order.
     *
     * @param string $orderId
     *
     * @return $response
     */
    public function getTransactionStatus($orderId)
    {
        // initialize an array
        $paytmParams = [];

        // set parameters
        $paytmParams['body'] = [
            'mid'     => config('paytm.merchant.id'),  // Paytm Merchant ID
            'orderId' => $orderId,
        ];

        // Generate a unique signature using PaytmChecksumhash.
        $generateSignature = PaytmChecksum::generateSignature(json_encode($paytmParams['body'], JSON_UNESCAPED_SLASHES), config('paytm.merchant.key'));

        // Add the generated signature to the parameters for posting.
        $paytmParams['head'] = ['signature' => $generateSignature];

        // Set the api endpoint for the testing environment
        if (config('paytm.environment') == 'testing') {
            $url = config('paytm.url.testing').'/v3/order/status';
        }

        // Set the api endpoint for the production environment
        elseif (config('paytm.environment' == 'production')) {
            $url = config('paytm.url.production').'/v3/order/status';
        }

        // Send an api request to PayTM.
        $response = $this->getcURLRequest($url, $paytmParams);

        // Return response.
        return $response;
    }

    /**
     * Send a POST request to the PayTM API endpoint.
     *
     * @param $url
     * @param $postDate
     * @param $headers
     *
     * @return $response
     */
    public function getcURLRequest($url, $postData = [], $headers = ['Content-Type: application/json'])
    {
        // Encode the JSON string for the request
        $post_data_string = json_encode($postData, JSON_UNESCAPED_SLASHES);

        // Initialize CURL.
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);

        // Return response.
        return json_decode($response, true);
    }
}
