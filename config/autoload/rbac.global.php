<?php

use ZfcRbac\Guard\GuardInterface;

return array(
    'zfc_rbac' => [

//        'role_provider' => [
//            'ZfcRbac\Role\InMemoryRoleProvider' => [
//                'admin' => [
//                    'children'    => ['member'],
//                    'permissions' => ['delete']
//                ],
//                'member' => [
//                    'permissions' => ['edit']
//                ]
//            ],
//        ],
//        'identity_provider' => 'MyCustomIdentityProvider',

//        'role_provider_manager' => [
//            'factories' => [
//                'Application\Role\CustomRoleProvider' => 'Application\Factory\CustomRoleProviderFactory'
//            ]
//        ],

        'protection_policy' => GuardInterface::POLICY_DENY,
    ]
);