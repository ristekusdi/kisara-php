<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Container;
use RistekUSDI\Kisara\AccessToken;

class Kisara
{   
    public static function connect($config)
    {
        Container::setup($config);
        
        if ((new AccessToken(Container::getToken()))->hasExpired()) {
            try {
                $client_id = Container::getClientId();
                $client_secret = Container::getClientSecret();
                $response = curl_request(Container::getTokenEndpoint(), array(
                    'header' => array(
                        'Content-Type: application/x-www-form-urlencoded',
                    ),
                    'user_pwd' => "{$client_id}:{$client_secret}",
                    'body' => 'grant_type=client_credentials',
                ), 'POST');
                
                if ($response['code'] === 200) {
                    Container::setToken($response['body']);
                    return Container::getToken();
                } else {
                    throw new \Exception($response['body']['error'], $response['code']);
                }
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }

        return Container::getToken();
    }

    public static function disconnect()
    {
        $client_id = Container::getClientId();
        $client_secret = Container::getClientSecret();
        $access_token = Container::getAccessToken();
        $response = curl_request(Container::getRevocationEndpoint(), array(
            'user_pwd' => "{$client_id}:{$client_secret}",
            'body' => "token={$access_token}",
        ), 'POST');
        
        if ($response['code'] === 200) {
            Container::setToken([]);
            return $response['body'];
        } else {
            throw new \Exception($response['body']['error'], $response['code']);
        }
    }
}