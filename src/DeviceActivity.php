<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class DeviceActivity extends Base
{
    public function get()
    {
        $url = "{$this->getBaseRealmUrl()}/account/sessions/devices";

        $response = curl_request($url, array(
            'header' => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->getToken()
            )
        ));
        
        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function endAllSession()
    {
        $url = "{$this->getBaseRealmUrl()}/account/sessions";
        
        return curl_request($url, array(
            'header' => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->getToken(),
            )
        ), 'DELETE');
    }

    public function endSession($session_id)
    {
        $url =  "{$this->getBaseRealmUrl()}/account/sessions/{$session_id}";

        return curl_request($url, array(
            'header' => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->getToken(),
            )
        ), 'DELETE');
    }
}