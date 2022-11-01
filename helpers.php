<?php

if (! function_exists('flatten_groups')) {
    function flatten_groups(array $array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (!empty($value['subGroups'])) {
                $result = array_merge($result, flatten_groups($value['subGroups']));
            }
            $result[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'path' => $value['path']
            );
        }
        return $result;
    }
}

if (! function_exists('curl_request')) {
    function curl_request($url, $params, $method = 'GET')
    {
        $curl = curl_init();

        $array_setopt = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
        ];

        if (isset($params['header'])) {
            $array_setopt[CURLOPT_HTTPHEADER] = $params['header'];
        }
        
        if (isset($params['user_pwd'])) {
            $array_setopt[CURLOPT_USERPWD] = $params['user_pwd'];
        }

        if (isset($params['body'])) {
            $array_setopt[CURLOPT_POSTFIELDS] = $params['body'];
        }

        curl_setopt_array($curl, $array_setopt);

        $body = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);

        return [
            'body' => json_decode($body, true),
            'code' => (int) $code
        ];
    }
}