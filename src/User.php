<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class User extends Base
{
    public function get($params = array())
    {
        $query = '';
        if (isset($params)) {
            $query = http_build_query($params);
        }

        $url = "{$this->getAdminRealmUrl()}/users?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
    }

    /**
     * Count number of users in Keycloak realm
     * @return integer
     */
    public function count($params = array())
    {
        $query = '';
        if (isset($params)) {
            $query = http_build_query($params);
        }

        $url = "{$this->getAdminRealmUrl()}/users/count?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        $result = 0;

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
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

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
    }

    public function getImpersonateUrl($data)
    {
        $users = $this->get($data);
        
        $user_id = (!empty($users)) ? $users[0]['id'] : '';

        if (empty($user_id)) {
            return response()->json(array(
                'status' => 'error',
                'message' => 'Cannot impersonate user because user not found!'
            ), 401);
        }

        return response()->json(array(
            'status' => 'ok',
            'impersonate_url' => "{$this->getAdminRealmUrl()}/users/{$user_id}/impersonation",
            'access_token' => $this->getToken()
        ), 200);
    }

    public function store($data)
    {
        $url = "{$this->getAdminRealmUrl()}/users";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'POST');

        return $response;
    }

    public function update($user_id, $data)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');

        $response['body'] = json_decode($response['body'], true);
        return $response;
    }

    public function getRawAvailableRoles($user_id, $client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}/available";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
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

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
    }

    public function getEffectiveRoles($user_id, $client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}/composite";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
    }

    public function storeAssignedClientRoles($user_id, $client_id, $roles)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}";
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'POST');
        
        $response['body'] = json_decode($response['body'], true);

        return $response;
    }

    public function deleteAssignedClientRoles($user_id, $client_id, $roles)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/role-mappings/clients/{$client_id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'DELETE');
        
        $response['body'] = json_decode($response['body'], true);

        return $response;
    }

    public function groups($user_id)
    {
        $url = "{$this->getAdminRealmUrl()}/users/{$user_id}/groups";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        $result = [];

        if ($response['code'] === 200) {
            $response['body'] = json_decode($response['body'], true);
        }

        return $response['body'];
    }

    public function resetPassword($user_id, $data)
    {
        $url = "{$this->getBaseUrl()}/admin/realms/{$this->getRealm()}/users/{$user_id}/reset-password";
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');

        $response['body'] = json_decode($response['body'], true);
        return $response;
    }
}