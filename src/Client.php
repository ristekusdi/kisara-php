<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class Client extends Base
{
    public function get($params = array())
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