<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class Group extends Base
{
    /**
     * Get list of groups
     */
    public function get($params = array())
    {
        $query = '';
        if (isset($params)) {
            $query = http_build_query($params);
        }

        $url = $this->getAdminRealmUrl()."/groups?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ), 'GET');

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
    }

    public function findById($id)
    {
        $url = "{$this->getAdminRealmUrl()}/groups/{$id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ), 'GET');

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
    }

    public function store($data)
    {
        $url = "{$this->getAdminRealmUrl()}/groups";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'POST');
    }

    public function delete($id)
    {
        $url = "{$this->getAdminRealmUrl()}/groups/{$id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
        ), 'DELETE');
    }

    public function getRawAvailableRoles($group_id, $client_id)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}/available";

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

    public function getAvailableRoles($group_id, $client_id)
    {
        $raw_available_roles = $this->getRawAvailableRoles($group_id, $client_id);
        
        $roles = [];
        $filtered_roles = ['uma_protection'];
        
        foreach ($raw_available_roles as $raw_role) {
            if (!in_array($raw_role['name'], $filtered_roles)) {
                $roles[] = $raw_role;
            }  
        }

        return $roles;
    }

    public function getAssignedRoles($group_id, $client_id)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}";
        
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

    public function getEffectiveRoles($group_id, $client_id)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}/composite";

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

    public function storeAssignedClientRoles($group_id, $client_id, $roles)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}";

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

    public function deleteAssignedClientRoles($group_id, $client_id, $roles)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}";

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

    public function members($group_id, $params = array())
    {
        $query = '';
        if (isset($params)) {
            $query = http_build_query($params);
        }

        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/members?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ));

        $response['body'] = json_decode($response['body'], true);

        return $response;
    }

    /**
     * Mendapatkan daftar kelompok berdasarkan role mapping client
     * @param $role_name, $client_id (id of client NOT client-id)
     * @return array of groups
     */
    public function getRoleMapping($role_name, $client_id)
    {
        $groups = flatten_groups($this->get());

        $filtered_groups = [];
        foreach ($groups as $group) {
            $assigned_roles = $this->getAssignedRoles($group['id'], $client_id);
            foreach ($assigned_roles as $assigned_role) {
                if ($assigned_role['name'] == $role_name) {
                    $filtered_groups[] = $group;
                }
            }
        }
        
        return $filtered_groups;
    }
}