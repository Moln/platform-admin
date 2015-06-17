<?php

return array(
    'router'       => array(
        'routes' => array(
            'model-manager'    => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/model-manager[/:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Moln\ModelManager',
                        'controller'    => 'index',
                        'action'        => 'index',
                    ),
                ),
                'child_routes' => array(
                    'params' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
            'model-manager-ui' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/ui/model-manager[/:ctrl[/:name]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Moln\ModelManager',
                        'controller'    => 'index',
                        'action'        => 'ui',
                    ),
                ),
            ),
        ),
    ),
    'zfc_rbac'     => [
        'guards' => [
            'Moln\Admin\Rbac\PermissionsGuard' => [
                'routes' => [
                    'model-manager*'
                ],
            ]
        ]
    ],

    'moln_admin'   => array(
        'menus'                          => array(
            'model_manager' => array(
                'text'     => '模型管理',
                'expanded' => true,
                'items'    => array(
                    array(
                        'text'  => '数据表模型',
                        'index' => 0,
                        'url'   => './ui/model-manager/data-source-config/index',
//                        'permission' => 'admin.user.index',
                    ),
                    array(
                        'text'  => '模型UI配置',
                        'index' => 1,
                        'url'   => './ui/model-manager/ui-config/index',
//                        'permission' => 'admin.role.index',
                    ),
                    array(
                        'text'  => '模型UI列表',
                        'index' => 1,
                        'url'   => './ui/model-manager/ui-config/list',
//                        'permission' => 'admin.role.index',
                    ),
                    array(
                        'text'  => '权限管理',
                        'index' => 2,
                        'url'   => './ui/model-manager/permission/index',
//                        'permission' => 'admin.permission.index',
                    ),
                    array(
                        'text'  => '查询测试4',
                        'url'   => './model-manager/source/view/id/4',
//                        'permission' => 'admin.permission.index',
                    ),
                    array(
                        'text'  => '查询测试2',
                        'url'   => './model-manager/source/view/id/2',
//                        'permission' => 'admin.permission.index',
                    ),
                ),
            ),
        ),
        'permission_scan_controller_dir' => array(
            'Moln\ModelManager' => __DIR__ . '/../src/Controller',
        ),
    ),

    'moln_model_manager' => array(
        'data_source_manager' => array(
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'db'           => array(
        'adapters' => array(
            'Moln\ModelManager'       => array(
                'driver'         => 'Pdo',
                'dsn'            => 'mysql:dbname=platform-admin;host=localhost;charset=utf8;',
                'username'       => 'root',
                'password'       => '',
            ),
        )
    ),

    'tables'       => array(
        'ModelManager\DataSourceConfigTable' => array(
            'table'   => 'model_manager_data_source_config',
            'primary' => 'id',
            'adapter' => 'Moln\ModelManager',
        ),
        'ModelManager\UiConfigTable' => array(
            'table'   => 'model_manager_ui_config',
            'invokable' => 'Moln\ModelManager\Model\UiConfigTable',
            'primary' => 'id',
            'adapter' => 'Moln\ModelManager',
        ),
    ),

    'service_manager' => array(
        'factories'  => array(
            'Moln\ModelManager\DataSourceManager' => 'Moln\ModelManager\DataSource\DataSourceManagerFactory',
        ),
    ),
);