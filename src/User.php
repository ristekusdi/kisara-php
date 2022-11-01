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

    /**
     * Count number of users in Keycloak realm
     * @return integer
     */
    public function count($params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getAdminRealmUrl()}/users/count?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : 0;
    }

    // $user_id = sub
    public function getById($user_id)
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

    public function getRawAvailableRoles($user_id, $client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}/available";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function getAvailableRoles($user_id, $client_id)
    {
        $raw_available_roles = $this->getRawAvailableRoles($user_id, $client_id);
        
        $roles = [];
        $filtered_roles = ['uma_protection'];
        
        foreach ($raw_available_roles as $raw_role) {
            if (!in_array($raw_role['name'], $filtered_roles)) {
                $roles[] = $raw_role;
            }  
        }

        return $roles;
    }

    public function getAssignedRoles($user_id, $client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function getEffectiveRoles($user_id, $client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}/composite";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function storeAssignedClientRoles($user_id, $client_id, $roles)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'POST');
    }

    public function deleteAssignedClientRoles($user_id, $client_id, $roles)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'DELETE');
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

    public function resetPassword($user_id, $data)
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
}