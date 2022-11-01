<?php

namespace RistekUSDI\Kisara;

class Base
{
    private $admin_url;
    private $base_url;
    private $realm;
    private $client_id;
    private $client_secret;
    private $username;
    private $password;

    public function __construct($config = array())
    {
        $this->admin_url = $config['admin_url'];
        $this->base_url = $config['base_url'];
        $this->realm = $config['realm'];
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
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

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
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
        $url = "{$this->getBaseRealmUrl()}/protocol/openid-connect/token";

        $response = curl_request($url, array(
            'header' => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
            'user_pwd' => "{$this->getClientId()}:{$this->getClientSecret()}",
            'body' => 'grant_type=client_credentials',
        ), 'POST');

        return ($response['code'] === 200) ? $response['body']['access_token'] : '';;
    }

    public function isTokenActive($token)
    {
        $url = "{$this->getBaseRealmUrl()}/protocol/openid-connect/token/introspect";

        $response = curl_request($url, array(
            'header' => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
            'user_pwd' => "{$this->getClientId()}:{$this->getClientSecret()}",
            'body' => "token_type_hint=requesting_party_token&token={$token}",
        ), 'POST');

        $result = false;

        if ($response['code'] === 200) {
            if (isset($response['body']['active'])) {
                if ($response['body']['active'] == true) {
                    $result = true;
                }
            }
        }

        return $result;
    }
}