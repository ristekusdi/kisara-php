<?php

namespace RistekUSDI\Kisara;

use RistekUSDI\Kisara\Base;

class Key extends Base
{
    public function get()
    {
        $url = $this->getAdminRealmUrl()."/keys";

        $response = curl_request($url, array(
            'header' => array(
                'Authorization: Bearer '.$this->getToken()
            ),
        ));

        $result = [];

        if ($response['code'] === 200) {
            $result = json_decode($response['body'], true);
        }

        return $result;
    }

    /**
     * Get RSA256 public key signature
     */
    public function getRSA256PublicKey()
    {
        $keys = $this->get();
        $available_keys = $keys['keys'];
        $public_key = null;

        foreach ($available_keys as $value) {
            if ($value['algorithm'] === 'RS256' && $value['use'] === 'SIG') {
                $public_key = $value['publicKey'];
            }
        }

        return $public_key;
    }
}