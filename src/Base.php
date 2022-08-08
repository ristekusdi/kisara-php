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
    private $token;

    public function __construct($config = array())
    {
        $this->admin_url = $config['admin_url'];
        $this->base_url = $config['base_url'];
        $this->realm = $config['realm'];
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
        $this->token = isset($config['token']) ? $config['token'] : null;
    }

    public function getAdminRealmUrl()
    {
        return "$this->admin_url/admin/realms/{$this->getRealm()}";
    }

    public function getBaseRealmUrl()
    {
        return "$this->base_url/realms/{$this->getRealm()}";
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

    public function getToken()
    {
        if (!empty($this->token)) {
            return $this->token;
        } else {
            $url = "{$this->getBaseRealmUrl()}/protocol/openid-connect/token";

            $response = curl_request($url, array(
                'header' => array(
                    'Content-Type: application/x-www-form-urlencoded',
                ),
                'user_pwd' => "{$this->getClientId()}:{$this->getClientSecret()}",
                'body' => 'grant_type=client_credentials',
            ), 'POST');

            if ($response['code'] === 200) {
                $decode_response = json_decode($response['body'], true);
                $access_token = $decode_response['access_token'];
            }

            return $access_token;
        }
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
            $decode_response = json_decode($response['body'], true);
            if (isset($decode_response['active'])) {
                if ($decode_response['active'] == true) {
                    $result = true;
                }
            }
        }

        return $result;
    }
}