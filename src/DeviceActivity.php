<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;

class DeviceActivity
{
    public static function get()
    {
        $base_realm_url = Container::getBaseRealmUrl();
        $url = "{$base_realm_url}/account/sessions/devices";

        $response = curl_request($url, array(
            'header' => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ));
        
        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function endAllSession()
    {
        $base_realm_url = Container::getBaseRealmUrl();
        $url = "{$base_realm_url}/account/sessions";
        
        return curl_request($url, array(
            'header' => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.Container::getAccessToken(),
            )
        ), 'DELETE');
    }

    public static function endSession($session_id)
    {
        $base_realm_url = Container::getBaseRealmUrl();
        $url =  "{$base_realm_url}/account/sessions/{$session_id}";

        return curl_request($url, array(
            'header' => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.Container::getAccessToken(),
            )
        ), 'DELETE');
    }
}