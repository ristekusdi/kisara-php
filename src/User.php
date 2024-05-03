<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;

class User
{
    public static function get($params = array())
    {   
        $query = isset($params) ? http_build_query($params) : '';
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function findById($id)
    {
        $base_url = Container::getBaseUrl();
        $realm = Container::getRealm();
        $url = "{$base_url}/admin/realms/{$realm}/users/{$id}";
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function store($data)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users";

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
        $url = "{$admin_realm_url}/users/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    public static function groups($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users/{$id}/groups";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function resetCredentials($id, $data)
    {
        $base_url = Container::getBaseUrl();
        $realm = Container::getRealm();
        $url = "{$base_url}/admin/realms/{$realm}/users/{$id}/reset-password";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    public static function getAvailableRoles($id, $client_id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users/{$id}/role-mappings/clients/{$client_id}/available";

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
        $url = "{$admin_realm_url}/users/{$id}/role-mappings/clients/{$client_id}/composite";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    /**
     * Assign user to role
     */
    public static function assignRole($id, $client_id, $roles)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users/{$id}/role-mappings/clients/{$client_id}";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'POST');
    }

    public static function getAssignedRoles($id, $client_id = null)
    {
        $base_url = Container::getBaseUrl();
        $realm = Container::getRealm();
        $url = "{$base_url}/admin/realms/{$realm}/users/{$id}/role-mappings";
        if (!is_null($client_id)) {
            $url = "{$base_url}/admin/realms/{$realm}/users/{$id}/role-mappings/clients/{$client_id}";
        }
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function unassignRole($id, $client_id, $roles)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users/{$id}/role-mappings/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'DELETE');
    }

    public static function getSessions($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users/{$id}/sessions";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public static function logout($id)
    {
        $admin_realm_url = Container::getAdminRealmUrl();
        $url = "{$admin_realm_url}/users/{$id}/logout";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            )
        ), 'POST');
    }

    public static function getActiveAppSessions()
    {
        $base_realm_url = Container::getBaseRealmUrl();
        $url = "{$base_realm_url}/account/applications";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.Container::getAccessToken(),
                'Content-Type: application/json'
            ),
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }
}