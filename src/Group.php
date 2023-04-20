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

    public function update($id, $data)
    {
        $url = "{$this->getAdminRealmUrl()}/groups/$id";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
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