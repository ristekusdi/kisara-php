<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;

class ClientRole
{
    public static function get($client_id, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$client_id}/roles?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function store($client_id, $data)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$client_id}/roles";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'POST');
    }

    /**
     * Get assigned users to role in client
     * @param $client_id $role_name
     * @return array of users
     */
    public static function getUsers($client_id, $role_name, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$client_id}/roles/{$role_name}/users?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    /**
     * Get assigned groups to role in client
     * @param $client_id $role_name
     * @return array of groups
     */
    public static function getGroups($client_id, $role_name, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/clients/{$client_id}/roles/{$role_name}/groups?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }
}