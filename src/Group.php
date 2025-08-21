<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;

class Group
{
    public static function get($params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function findById($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function store($data)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'POST');
    }

    public static function update($id, $data)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/$id";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    public static function delete($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
        ), 'DELETE');
    }

    public static function members($id, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = Container::getAdminRealmUrl()."/groups/{$id}/members?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function addMember($id, $user_id)
    {
        $url = Container::getAdminRealmUrl()."/users/{$user_id}/groups/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ), 'PUT');
    }

    public static function removeMember($id, $user_id)
    {
        $url = Container::getAdminRealmUrl()."/users/{$user_id}/groups/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ), 'DELETE');
    }

    public static function getRoleMappings($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}/role-mappings";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function getAvailableRoles($id, $client_id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}/role-mappings/clients/{$client_id}/available";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function getEffectiveRoles($id, $client_id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}/role-mappings/clients/{$client_id}/composite";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function assignRole($id, $client_id, $roles)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}/role-mappings/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'POST');
    }

    public static function getAssignedRoles($id, $client_id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}/role-mappings/clients/{$client_id}";
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function unassignRole($id, $client_id, $roles)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/groups/{$id}/role-mappings/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'DELETE');
    }
}