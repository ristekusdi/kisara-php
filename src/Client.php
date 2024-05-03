<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;

class Client
{
    public static function get($params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function findById($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function store($data)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data)
        ), 'POST');
    }

    public static function update($id, $client)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($client, JSON_UNESCAPED_SLASHES),
        ), 'PUT');
    }

    public static function delete($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
        ), 'DELETE');
    }

    public static function getClientSecret($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$id}/client-secret";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ));
        
        $secret = "";
        if ($response['code'] === 200) {
            if (isset($response['body']['value'])) {
                $secret = $response['body']['value'];
            }
        }
        
        return $secret;
    }

    public static function updateClientSecret($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$id}/client-secret";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ), 'POST');
        
        return ($response['code'] === 200) ? $response['body']['value'] : 0;
    }

    public static function getServiceAccountUser($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$id}/service-account-user";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
            ),
        ));
    }

    public static function userSessions($id, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$id}/user-sessions?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }
}