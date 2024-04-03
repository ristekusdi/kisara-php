<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;

class Role
{
    public static function findById($role_id)
    {
        $url =  Container::getAdminRealmUrl()."/roles-by-id/{$role_id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function update($role_id, $data)
    {
        $url =  Container::getAdminRealmUrl()."/roles-by-id/{$role_id}";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    public static function delete($role_id)
    {
        $url =  Container::getAdminRealmUrl()."/roles-by-id/{$role_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            )
        ), 'DELETE');
    }
}