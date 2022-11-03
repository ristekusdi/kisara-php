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
        $query = isset($params) ? http_build_query($params) : '';
        $url = $this->getAdminRealmUrl()."/groups?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function findById($id)
    {
        $url = "{$this->getAdminRealmUrl()}/groups/{$id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
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

        return ($response['code'] === 200) ? $response['body'] : [];
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

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function getEffectiveRoles($group_id, $client_id)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}/composite";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function storeAssignedClientRoles($group_id, $client_id, $roles)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'POST');
    }

    public function deleteAssignedClientRoles($group_id, $client_id, $roles)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($roles),
        ), 'DELETE');
    }

    public function members($group_id, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/members?{$query}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            )
        ));
    }

    public function getRoleMappings($group_id)
    {
        $url = "{$this->getBaseUrl()}/admin/realms/{$this->getRealm()}/groups/{$group_id}/role-mappings";
        
        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
        ), 'GET');

        return ($response['code'] === 200) ? $response['body'] : [];
    }
}