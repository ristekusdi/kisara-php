<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class Role extends Base
{
    public function get($role_id)
    {
        $url =  $this->getAdminRealmUrl()."/roles-by-id/{$role_id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            )
        ));

        return ($response['code'] === 200) ? $response['body'] : [];
    }

    public function update($role_id, $data)
    {
        $url =  $this->getAdminRealmUrl()."/roles-by-id/{$role_id}";
        
        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            ),
            'body' => json_encode($data),
        ), 'PUT');
    }

    public function delete($role_id)
    {
        $url =  $this->getAdminRealmUrl()."/roles-by-id/{$role_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            )
        ), 'DELETE');
    }
}