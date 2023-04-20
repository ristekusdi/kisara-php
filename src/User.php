<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class User extends Base
{
    public function get($params = array())
    {   
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getAdminRealmUrl()}/users?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    // $user_id = sub
    public function findById($user_id)
    {
        $url = "{$this->getBaseUrl()}/admin/realms/{$this->getRealm()}/users/{$user_id}";
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function store($data)
    {
        $url = "{$this->getAdminRealmUrl()}/users";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'POST');
    }

    public function update($user_id, $data)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    public function groups($user_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/groups";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function resetCredentials($user_id, $data)
    {
        $url = "{$this->getBaseUrl()}/admin/realms/{$this->getRealm()}/users/{$user_id}/reset-password";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    public function getRoleMappings($user_id)
    {
        $url = "{$this->getBaseUrl()}/admin/realms/{$this->getRealm()}/users/{$user_id}/role-mappings";
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    /**
     * Get user sessions
     */
    public function getUserSessions($user_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/sessions";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    /**
     * Logout user
     */
    public function logout($user_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/logout";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            )
        ), 'POST');
    }
}