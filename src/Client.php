<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class Client extends Base
{

    public function getRaw($params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getAdminRealmUrl()}/clients?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function get($params = array())
    {
        $raw_clients = $this->getRaw($params);
        
        $clients = [];
        $filtered_clients = [
            'account',
            'account-console',
            'admin-cli',
            'broker',
            'realm-management',
            'security-admin-console'
        ];
        
        foreach ($raw_clients as $raw_client) {
            if (!in_array($raw_client['clientId'], $filtered_clients)) {
                $clients[] = $raw_client;
            }  
        }

        return $clients;
    }

    public function findById($client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function store($data)
    {
        $url = "{$this->getAdminRealmUrl()}/clients";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data)
        ), 'POST');
    }

    public function update($client_id, $client)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($client, JSON_UNESCAPED_SLASHES),
        ), 'PUT');
    }

    public function delete($client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
        ), 'DELETE');
    }

    public function getRawRoles($client_id, $params)
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/roles?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function getRoles($client_id, $params = array())
    {
        $raw_roles = $this->getRawRoles($client_id, $params);
        
        $roles = [];
        $filtered_roles = [
            'uma_protection'
        ];
        
        foreach ($raw_roles as $raw_role) {
            if (!in_array($raw_role['name'], $filtered_roles)) {
                $roles[] = $raw_role;
            }  
        }

        return $roles;
    }

    public function storeRole($client_id, $data)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/roles";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'POST');
    }

    public function getRole($client_id, $role_name)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/roles/{$role_name}";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
        ));
    }

    public function updateRole($client_id, $role_name, $data)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/roles/{$role_name}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    /**
     * Get users based on client id and role name
     * @param $client_id $role_name
     * @return array of users
     */
    public function getUsersInRole($client_id, $role_name, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/roles/{$role_name}/users?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function getServiceAccountUser($client_id)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/service-account-user";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
            ),
        ));
    }
}