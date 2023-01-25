<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class GroupClientRole extends Base
{
    public function getAvailableRoles($group_id, $client_id)
    {
        $url = $this->getAdminRealmUrl()."/groups/{$group_id}/role-mappings/clients/{$client_id}/available";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function storeAssignedRoles($group_id, $client_id, $roles)
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

    public function deleteAssignedRoles($group_id, $client_id, $roles)
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
}