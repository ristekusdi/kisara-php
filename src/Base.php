<?php

namespace RistekUSDI\Kisara;

class Base
{
    private $admin_url;
    private $base_url;
    private $realm;
    private $client_id;
    private $client_secret;
    private $access_token;

    public function __construct($config = array())
    {
        $this->admin_url = isset($config['admin_url']) ? $config['admin_url'] : null;
        $this->base_url = isset($config['base_url']) ? $config['base_url'] : null;
        $this->realm = isset($config['realm']) ? $config['realm'] : null;
        $this->client_id = isset($config['client_id']) ? $config['client_id'] : null;
        $this->client_secret = isset($config['client_secret']) ? $config['client_secret'] : null;
        $this->access_token = isset($config['access_token']) ? $config['access_token'] : null;
    }

    public function getAdminUrl()
    {
        return $this->admin_url;
    }

    public function getBaseUrl()
    {
        return $this->base_url;
    }

    public function getRealm()
    {
        return $this->realm;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function getClientSecret()
    {
        return $this->client_secret;
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getAdminRealmUrl()
    {
        return "$this->admin_url/admin/realms/{$this->getRealm()}";
    }

    public function getBaseRealmUrl()
    {
        return "$this->base_url/realms/{$this->getRealm()}";
    }

    public function getToken()
    {
        if (!empty($this->getAccessToken())) {
            return $this->getAccessToken();
        } else {
            $url = "{$this->getBaseRealmUrl()}/protocol/openid-connect/token";

            $response = curl_request($url, array(
                'header' => array(
                    'Content-Type: application/x-www-form-urlencoded',
                ),
                'user_pwd' => "{$this->getClientId()}:{$this->getClientSecret()}",
                'body' => 'grant_type=client_credentials',
            ), 'POST');
    
            return ($response['code'] === 200) ? $response['body']['access_token'] : '';
        }
    }
}