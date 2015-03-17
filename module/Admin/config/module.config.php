<?php
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
    'file_storage'    => array(
        'type'    => 'fileSystem',
        'options' => array(
            'default_path' => realpath('./public/uploads'),
            'validators'   => array(
                'Extension' => array('gif', 'jpg', 'jpeg', 'png'),
                'Size'      => array('max' => 1024 * 1024),
                'IsImage',
            ),
            'filters'      => array(
                'LowerCaseName',
                'RenameUpload' => array(
                    'target'               => date('Y/m') . '/shop',
                    'use_upload_extension' => true,
                    'randomize'            => true,
                ),
            ),
        ),
    ),


    'auth_module'     => array(
        'admin',
//        'shop',
//        'payment',
    ),
    'service_manager' => array(
        'factories'          => array(
            'FileStorage' => '\Gzfextra\FileStorage\StorageFactory'
        ),
        'abstract_factories' => array(//            'Gzfextra\FileStorage\StorageAbstractFactory',
        )
    ),
    'caches'          => array(
        'cache.permission' => array(
            'adapter' => 'filesystem',
            'options' => array(
                'cacheDir' => './data/cache'
            ),
            'plugins' => array('serializer'),
        ),
    ),
);