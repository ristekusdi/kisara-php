<?php
namespace RistekUSDI\Kisara;

class Container {
    private static $admin_url, $base_url, $realm, $client_id, $client_secret;
    private static $token = [];

    public static function setup($config)
    {
        self::$admin_url = isset($config['admin_url']) ? $config['admin_url'] : null;
        self::$base_url = isset($config['base_url']) ? $config['base_url'] : null;
        self::$realm = isset($config['realm']) ? $config['realm'] : null;
        self::$client_id = isset($config['client_id']) ? $config['client_id'] : null;
        self::$client_secret = isset($config['client_secret']) ? $config['client_secret'] : null;
    }

    public static function getAdminUrl()
    {
        return self::$admin_url;
    }

    public static function getBaseUrl()
    {
        return self::$base_url;
    }

    public static function getRealm()
    {
        return self::$realm;
    }

    public static function getClientId()
    {
        return self::$client_id;
    }

    public static function getClientSecret()
    {
        return self::$client_secret;
    }

    public static function getAdminRealmUrl()
    {
        $admin_url = self::getAdminUrl();
        $realm = self::getRealm();
        return "{$admin_url}/admin/realms/{$realm}";
    }

    public static function getBaseRealmUrl()
    {
        $base_url = self::getBaseUrl();
        $realm = self::getRealm();
        return "{$base_url}/realms/{$realm}";
    }

    public static function getTokenEndpoint()
    {
        $base_realm_url = self::getBaseRealmUrl();
        return "{$base_realm_url}/protocol/openid-connect/token";
    }

    public static function setToken($token)
    {
        self::$token = $token;
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function getAccessToken()
    {
        return self::$token['access_token'] ?? null;
    }
}