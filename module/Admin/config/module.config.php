<?php

use Zend\Mvc\ModuleRouteListener;
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
            'admin'  => array(
                'type'         => 'segment',
                'options'      => array(
                    'route'       => '/admin[/:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        '__NAMESPACE__'     => 'Moln\Admin',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
                'child_routes' => array(
                    'params' => array(
                        'type' => 'Wildcard',
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
            'Admin\AuthenticationAdapterPluginManager' => 'Moln\Admin\Factory\AuthenticationAdapterPluginManagerFactory',
            'Admin\AuthenticationService'              => 'Moln\Admin\Factory\AuthenticationServiceFactory',
        ),
        'invokables' => array(
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
            'Zend\ModuleRouteListener'                  => ModuleRouteListener::class,
        ),
    ),

    'controllers' => array(
        'abstract_factories' => array(
            'Gzfextra\Mvc\Controller\ControllerLoaderAbstractFactory',
        ),
    ),

    'listeners'       => array(
        'Zend\ModuleRouteListener',
        'ZfcRbac\View\Strategy\RedirectStrategy',
    ),

    'caches'          => array(),

    'zfc_rbac'        => [
        'guards'                => [
            'Moln\Admin\Rbac\PermissionsGuard' => [
                'routes'            => [
                    'admin*'
                ],
                'protection_policy' => GuardInterface::POLICY_ALLOW,
            ],
        ],

        'role_provider'         => [
            'Moln\Admin\Rbac\RoleProvider' => [],
        ],

        'guard_manager'         => [
            'invokables' => [
                'Moln\Admin\Rbac\PermissionsGuard' => 'Moln\Admin\Rbac\PermissionsGuard',
            ]
        ],
        'role_provider_manager' => [
            'invokables' => [
                'Moln\Admin\Rbac\RoleProvider' => 'Moln\Admin\Rbac\RoleProvider',
            ]
        ],
    ],

    'moln_admin'      => array(
        'menus' => array(
            0 => array(
                'text'     => '系统',
                'index'    => 0,
                'expanded' => true,
                'items'    => array(
                    0 => array(
                        'text'       => '用户管理',
                        'index'      => 0,
                        'url'        => './admin/user',
                        'permission' => 'admin.user.index',
                    ),
                    1 => array(
                        'text'       => '角色管理',
                        'index'      => 1,
                        'url'        => './admin/role',
                        'permission' => 'admin.role.index',
                    ),
                    2 => array(
                        'text'       => '权限管理',
                        'index'      => 2,
                        'url'        => './admin/permission',
                        'permission' => 'admin.permission.index',
                    ),
                    4 => array(
                        'text'  => '个人信息',
                        'index' => 4,
                        'url'   => './admin/index/self',
                    ),
                    5 => array(
                        'text'       => '角色关系',
                        'index'      => 5,
                        'url'        => './admin/role/trees',
                        'permission' => 'admin.role.trees',
                    ),
                    6 => array(
                        'text'       => '操作日志',
                        'index'      => 6,
                        'url'        => './admin/operation-log/list',
                        'permission' => 'admin.operation-log.list',
                    ),
                ),
            ),
            1 => array(
                'text'       => '产品管理',
                'index'      => 1,
                'expanded'   => true,
                'permission' => 'product.index.index',
                'items'      => array(
                    0 => array(
                        'text'       => '产品管理',
                        'index'      => 0,
                        'url'        => './product',
                        'permission' => 'product.index.index',
                    ),
                ),
            ),
        ),
    ),

    'tables'          => array(
        'Admin\ParamPermissionTable'  => array(
            'table'     => 'admin_param_permission',
            'invokable' => 'Moln\Admin\Model\ParamPermissionTable',
            'primary'   => array(),
        ),
        'Admin\AssignPermissionTable' => array(
            'table'     => 'admin_assign_role_permission',
            'invokable' => 'Moln\Admin\Model\AssignPermissionTable',
            'primary'   => 'role_id',
        ),
        'Admin\AssignUserTable'       => array(
            'table'     => 'admin_assign_user_role',
            'invokable' => 'Moln\Admin\Model\AssignUserTable',
            'primary'   => array(),
        ),
        'Admin\PermissionTable'       => array(
            'table'     => 'admin_permission',
            'invokable' => 'Moln\Admin\Model\PermissionTable',
            'row'       => true,
            'primary'   => 'per_id',
        ),
        'Admin\RoleTable'             => array(
            'table'     => 'admin_role',
            'invokable' => 'Moln\Admin\Model\RoleTable',
            'primary'   => 'role_id',
            'row'       => true,
        ),
        'Admin\UserTable'             => array(
            'table'     => 'admin_user',
            'invokable' => 'Moln\Admin\Model\UserTable',
            'row'       => 'Admin\Model\User',
            'primary'   => 'user_id',
        ),
    ),
);