<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class ClientRole extends Base
{
    public function get($client_id, $params)
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

    public function store($client_id, $data)
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

    public function findByName($client_id, $role_name)
    {
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/roles/{$role_name}";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
        ));
    }

    public function update($client_id, $role_name, $data)
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
    public function getUsers($client_id, $role_name, $params = array())
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

    /**
     * Get groups based on client id and role name
     * @param $client_id $role_name
     * @return array of groups
     */
    public function getGroups($client_id, $role_name, $params = array())
    {
        $query = isset($params) ? http_build_query($params) : '';
        $url = "{$this->getAdminRealmUrl()}/clients/{$client_id}/roles/{$role_name}/groups?{$query}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }
}