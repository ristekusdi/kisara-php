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
        
        return ($response['code'] === 200) ? $response['body']['value'] : 0;
    }

    public function update($client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/client-secret";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ), 'POST');
        
        return ($response['code'] === 200) ? $response['body']['value'] : 0;
    }
}
