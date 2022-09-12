<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class ClientSecret extends Base
{
    public function get($client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/client-secret";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ));
        
        $result = 0;
        if ((int) $response['code'] === 200) {
            $body = isset($response['body']) ? json_decode($response['body'], true) : '';
            if (isset($body['value'])) {
                $result = $body['value'];
            }
        }

        return $result;
    }

    public function update($client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/client-secret";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ), 'POST');
        
        $result = 0;
        if ((int) $response['code'] === 200) {
            $body = isset($response['body']) ? json_decode($response['body'], true) : '';
            if (isset($body['value'])) {
                $result = $body['value'];
            }
        }

        return $result;
    }
}
