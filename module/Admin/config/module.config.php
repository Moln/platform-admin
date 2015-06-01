<?php
use Admin\Listener\OperationListener;
use Admin\Listener\PermissionGuardListener;
use Gzfextra\Router\GlobalModuleRouteListener;
use ZfcRbac\Guard\GuardInterface;

return array(
    'router'          => array(
        'routes' => array(
            'home'   => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'module'     => 'admin',
                        'controller' => 'auth',
                        'action'     => 'login',
                    ),
                ),
            ),
            'login'  => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        'module'     => 'admin',
                        'controller' => 'auth',
                        'action'     => 'login',
                    ),
                ),
            ),
            'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'module'     => 'admin',
                        'controller' => 'auth',
                        'action'     => 'logout',
                    ),
                ),
            ),
        ),
    ),

    'view_manager'    => array(
        'template_map'        => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'service_manager' => array(
        'factories'  => array(
            'FileStorage'                       => '\Gzfextra\File\Storage\StorageFactory',
            'Admin\AuthenticationPluginManager' => 'AuthenticationPluginManagerFactory',
            'Admin\Rbac'                        => 'Admin\Service\RbacFactory',
        ),
        'invokables' => array(
            'GlobalModuleRouteListener' => GlobalModuleRouteListener::class,
            'PermissionListener'        => PermissionGuardListener::class,
            'OperationListener'         => OperationListener::class,
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
        ),
    ),

    'listeners'       => array(
        'GlobalModuleRouteListener',
//        'PermissionListener',
//        'OperationListener',

        'ZfcRbac\View\Strategy\RedirectStrategy',
    ),

    'caches'          => array(
        'cache.permission' => array(
            'adapter' => 'filesystem',
            'ttl'     => 60,
            'options' => array(
                'cacheDir' => './data/cache'
            ),
            'plugins' => array('serializer'),
        ),
    ),


    'zfc_rbac'        => [
        'guards'                => [
//            'ZfcRbac\Guard\RouteGuard'    => [
//                'module*' => ['admin'],
//                'login'   => ['guest']
//            ],
            'Admin\Rbac\PermissionsGuard' => [
                'routes' => [
                    'module*'
                ]
            ],
        ],

        'role_provider'         => [
            'Admin\Rbac\RoleProvider' => ['cache' => 'cache.permission'],
        ],
//        'identity_provider' => 'MyCustomIdentityProvider',

        'guard_manager'         => [
            'invokables' => [
                'Admin\Rbac\PermissionsGuard' => 'Admin\Rbac\PermissionsGuard',
            ]
        ],
        'role_provider_manager' => [
            'invokables' => [
                'Admin\Rbac\RoleProvider' => 'Admin\Rbac\RoleProvider',
            ]
        ],
    ],

    'moln_admin'      => [
        'db_cache' => '',
        'authentication_manager' => array(
            'factories'  => array(
            ),
        ),
        'auth_adapter' => []
    ],

) + include 'table.config.php';