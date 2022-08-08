<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class Role extends Base
{
    public function delete($role_id)
    {
        $url =  $this->getAdminRealmUrl()."/roles-by-id/{$role_id}";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            )
        ), 'DELETE');

        $response['body'] = json_decode($response['body'], true);
        return $response;
    }
}