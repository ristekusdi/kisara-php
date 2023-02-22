<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class Session extends Base
{
    public function delete($session_id)
    {
        $url =  $this->getAdminRealmUrl()."/sessions/{$session_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken(),
                'Content-Type: application/json'
            )
        ), 'DELETE');
    }
}