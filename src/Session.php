<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;

class Session
{
    public static function delete($id)
    {
        $url =  Container::getAdminRealmUrl()."/sessions/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            )
        ), 'DELETE');
    }
}