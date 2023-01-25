# Kisara (Keycloak Service Account)

Keycloak Service Account library with minimum PHP version 7.2. Adapted from [Keycloak REST API](https://www.keycloak.org/docs-api/20.0.3/rest-api/index.html).

All class extends a Base class which is a class to get ADMIN_URL, BASE_URL, REALM, authentication to get token, and ACCESS_TOKEN.

## Get Started

```bash
composer require ristekusdi/kisara-php
```

In each class, you need to set a config (array value) to get data you need. Here's the available options:

```php

// First option
$config = [
    'admin_url' => 'ADMIN_KEYCLOAK_URL',
    'base_url' => 'BASE_KEYCLOAK_URL',
    'realm' => 'KEYCLOAK_REALM',
    'client_id' => 'KEYCLOAK_CLIENT_ID',
    'client_secret' => 'KEYCLOAK_CLIENT_SECRET',
];

// Second option
$config = [
    'admin_url' => 'ADMIN_KEYCLOAK_URL',
    'base_url' => 'BASE_KEYCLOAK_URL',
    'realm' => 'KEYCLOAK_REALM',
    'access_token' => 'ACCESS_TOKEN_FROM_SERVICE_ACCOUNTS_OF_CLIENT',
];
```

**Notes:** Admin url and base url in your Keycloak project may same url or maybe different.

## Available Classes and Methods

### Client

#### get

Get all client with or without parameters.

```php
use RistekUSDI\Kisara\Client as KisaraClient;

// With parameters
(new KisaraClient($config))->get([
    'clientId' => 'CLIENT_ID_NAME',
    'search' => 'true'
]);

// Without parameters
(new KisaraClient($config))->get();
```

#### findById

Get a client by id of client NOT clientId.

```php
use RistekUSDI\Kisara\Client as KisaraClient;

(new KisaraClient($config))->findById($client_id);
```

#### store

Store a client.

```php
use RistekUSDI\Kisara\Client as KisaraClient;

$data = [
    'enabled' => 'true',
    'protocol' => 'openid-connect',
    'clientId' => $clientId,
    'rootUrl' => $rootUrl,
    // Determine if client type is public or confidential
    // true = public, false = confidential
    'publicClient' => $publicClient,
];

(new KisaraClient($config))->store($data);
```
#### update

Update a client by id of client NOT clientId.

```php
use RistekUSDI\Kisara\Client as KisaraClient;

$data = [
    'enabled' => 'true',
    'protocol' => 'openid-connect',
    'clientId' => $clientId,
    'rootUrl' => $rootUrl,
    // Determine if client type is public or confidential
    // true = public, false = confidential
    'publicClient' => $publicClient,
];

(new KisaraClient($config))->update($client_id, $data);
```

#### delete

Delete client by id of client NOT clientId.

```php
use RistekUSDI\Kisara\Client as KisaraClient;

(new KisaraClient($config))->delete($client_id);
```

#### getServiceAccountUser

Get service account user from a client with id of client NOT clientId.

```php
use RistekUSDI\Kisara\Client as KisaraClient;

(new KisaraClient($config))->getServiceAccountUser($client_id);
```

### ClientRole

#### get

Get roles of client by id of client NOT clientId. Parameters are optional.

```php
use RistekUSDI\Kisara\ClientRole as KisaraClientRole;

$params = [
    'first' => '0',
    'max' => '10',
    'search' => 'role name of client',
]

(new KisaraClientRole($config))->get($client_id, $params);
```

#### store

Store a role to a client by id of client NOT clientId.

```php
use RistekUSDI\Kisara\ClientRole as KisaraClientRole;

$data = [
    'name' => 'role name of client',
]

(new KisaraClientRole($config))->store($client_id, $data);
```

#### getUsers

Get users from a client role with id of client and role name. Parameters are optional.

```php
use RistekUSDI\Kisara\ClientRole as KisaraClientRole;

$params = [
    'first' => '0',
    'max' => '10'
];

(new KisaraClientRole($config))->getUsers($client_id, $role_name, $params);
```

#### getGroups

Get groups from a client role with id of client and role name. Parameters are optional.

```php
use RistekUSDI\Kisara\ClientRole as KisaraClientRole;

$params = [
    'first' => '0',
    'max' => '10'
];

(new KisaraClientRole($config))->getGroups($client_id, $role_name, $params);
```

### ClientSecret

#### get

Get client secret of client by id of client NOT clientId.

```php
use RistekUSDI\Kisara\ClientSecret as KisaraClientSecret;

(new KisaraClientSecret($config))->get($client_id);
```

#### update

Update client secret of client by id of client NOT clientId.

```php
use RistekUSDI\Kisara\ClientSecret as KisaraClientSecret;

(new KisaraClientSecret($config))->update($client_id);
```

### Group

#### get

Get groups with or without parameters.

```php
use RistekUSDI\Kisara\Group as KisaraGroup;

// With parameters.
$params = [
    'first' => '0',
    'max' => '10',
    'search' => 'name of group',
];

(new KisaraGroup($config))->get($params);

// Without parameters.
(new KisaraGroup($config))->get();
```

#### findById

Get a single group by id of group.

```php
use RistekUSDI\Kisara\Group as KisaraGroup;

(new KisaraGroup($config))->findById($group_id);
```

#### store

Store a group.

```php
use RistekUSDI\Kisara\Group as KisaraGroup;

(new KisaraGroup($config))->store(array(
    'name' => 'name of group'
));
```

#### delete

Delete a group by id of group.

```php
use RistekUSDI\Kisara\Group as KisaraGroup;

(new KisaraGroup($config))->delete($group_id);
```

#### members

Get members of group by id of group. Parameters are optional.

```php
use RistekUSDI\Kisara\Group as KisaraGroup;

// With parameters.
$params = [
    'first' => '0',
    'max' => '10',
];
(new KisaraGroup($config))->members($group_id, $params);

// Without parameters.
(new KisaraGroup($config))->members($group_id);
```

#### getRoleMappings

Get group role mappings by group id.

```php
use RistekUSDI\Kisara\Group as KisaraGroup;

// Without parameters.
(new KisaraGroup($config))->getRoleMappings($group_id);
```

### GroupClientRole

#### getAvailableRoles

Get available roles of client role in a group.

```php
use RistekUSDI\Kisara\GroupClientRole as KisaraGroupClientRole;

(new KisaraGroupClientRole($config))->getAvailableRoles($group_id, $client_id);
```

#### storeAssignedRoles

Store assigned roles of client role to a group.

```php
use RistekUSDI\Kisara\GroupClientRole as KisaraGroupClientRole;

(new KisaraGroupClientRole($config))->storeAssignedRoles($group_id, $client_id, $roles);
```

#### getAssignedRoles

Get assigned roles of client role from a group.

```php
use RistekUSDI\Kisara\GroupClientRole as KisaraGroupClientRole;

(new KisaraGroupClientRole($config))->getAssignedRoles($group_id, $client_id);
```

#### deleteAssignedRoles

Delete assigned roles of client role from a group.

```php
use RistekUSDI\Kisara\GroupClientRole as KisaraGroupClientRole;

(new KisaraGroupClientRole($config))->deleteAssignedRoles($group_id, $client_id);
```

#### getEffectiveRoles

Get effective roles of client role from a group.

```php
use RistekUSDI\Kisara\GroupClientRole as KisaraGroupClientRole;

(new KisaraGroupClientRole($config))->getEffectiveRoles($group_id, $client_id);
```

### Key

#### get

Get all key from Keycloak realm settings.

```php
use RistekUSDI\Kisara\Key as KisaraKey;

(new KisaraKey($config))->get();
```

#### getRSA256PublicKey

Get RSA 256 Public Key from Keycloak realm settings.

```php
use RistekUSDI\Kisara\Key as KisaraKey;

(new KisaraKey($config))->getRSA256PublicKey();
```

### Role

#### findById

Find a role by id of role.

```php
use RistekUSDI\Kisara\Role as KisaraRole;

(new KisaraRole($config))->findById($role_id);
```

#### update

Update a role by id of role.

```php
use RistekUSDI\Kisara\Role as KisaraRole;

$data = [
    'name' => 'role name'
]

(new KisaraRole($config))->update($role_id, $data);
```

#### delete

Delete a role by id of role.

```php
use RistekUSDI\Kisara\Role as KisaraRole;

(new KisaraRole($config))->delete($role_id);
```

### User

#### get

Get users with or without parameters.

```php
use RistekUSDI\Kisara\User as KisaraUser;

// With parameters
$params = [
    // Option 1
    'username' => 'username',
    'exact' => true,

    // Option 2
    'email' => 'mail of user',
    'username' => 'username',
];

(new KisaraUser($config))->get($params);

// Without parameters
(new KisaraUser($config))->get();
```

#### findById

Find user by id of user.

```php
use RistekUSDI\Kisara\User as KisaraUser;

(new KisaraUser($config))->findById($user_id);
```

#### store

Store a user.

```php
use RistekUSDI\Kisara\User as KisaraUser;

$data = [
    'firstName' => 'first name of user',
    'lastName' => 'last name of user',
    'email' => 'email of user',
    'username' => 'username',
    'enabled' => true,
    'credentials' => [
        [
            'temporary' => true,
            'type' => 'password',
            'value' => 'value of password.'
        ]
    ],
];

(new KisaraUser($config))->store($data);
```

#### update

Update a user.

```php
use RistekUSDI\Kisara\User as KisaraUser;

$data = [
    'firstName' => 'first name of user',
    'lastName' => 'last name of user',
    'email' => 'email of user',
    'username' => 'username',
    'enabled' => true,
    'credentials' => [
        [
            'temporary' => true,
            'type' => 'password',
            'value' => 'value of password.'
        ]
    ],
];

(new KisaraUser($config))->update($user_id, $data);
```

#### groups

Get groups belong to user with id of user.

```php
use RistekUSDI\Kisara\User as KisaraUser;

(new KisaraUser($config))->groups($user_id);
```

#### resetCredentials

Reset user credentials.

```php
use RistekUSDI\Kisara\User as KisaraUser;

$data = array(
    'type' => 'password',
    'value' => 'value of password',
    'temporary' => true,
);

(new KisaraUser($config))->resetCredentials($user_id, $data);
```

### UserClientRole

#### getAvailableRoles

Get available roles of client role in a user.

```php
use RistekUSDI\Kisara\UserClientRole as KisaraUserClientRole;

(new KisaraUserClientRole($config))->getAvailableRoles($user_id, $client_id);
```

#### storeAssignedRoles

Store assigned roles of client role to a user.

```php
use RistekUSDI\Kisara\UserClientRole as KisaraUserClientRole;

(new KisaraUserClientRole($config))->storeAssignedRoles($user_id, $client_id, $roles);
```

#### getAssignedRoles

Get assigned roles of client role from a user.

```php
use RistekUSDI\Kisara\UserClientRole as KisaraUserClientRole;

(new KisaraUserClientRole($config))->getAssignedRoles($user_id, $client_id);
```

#### deleteAssignedRoles

Delete assigned roles of client role from a user.

```php
use RistekUSDI\Kisara\UserClientRole as KisaraUserClientRole;

(new KisaraUserClientRole($config))->deleteAssignedRoles($user_id, $client_id);
```

#### getEffectiveRoles

Get effective roles of client role from a user.

```php
use RistekUSDI\Kisara\UserClientRole as KisaraUserClientRole;

(new KisaraUserClientRole($config))->getEffectiveRoles($user_id, $client_id);
```

### UserGroup

#### attach

Attach a group to a user.

```php
use RistekUSDI\Kisara\UserGroup as KisaraUserGroup;

(new KisaraUserGroup($config))->attach($user_id, $group_id);
```

#### detach

Detach a group from a user.

```php
use RistekUSDI\Kisara\UserGroup as KisaraUserGroup;

(new KisaraUserGroup($config))->detach($user_id, $group_id);
```