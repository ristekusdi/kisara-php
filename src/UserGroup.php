<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class UserGroup extends Base
{
    public function attach($user_id, $group_id)
    {
        $url = $this->getAdminRealmUrl()."/users/{$user_id}/groups/{$group_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ), 'PUT');
    }

    public function detach($user_id, $group_id)
    {
        $url = $this->getAdminRealmUrl()."/users/{$user_id}/groups/{$group_id}";

        return curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ), 'DELETE');
    }
}