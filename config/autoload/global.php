<?php

return array(
    'db'                 => array(
        'adapters' => array(
            'db'       => array(
                'driver'         => 'Pdo',
                'dsn'            => 'mysql:dbname=platform-admin;host=localhost',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ),
                'username'       => 'root',
                'password'       => '',
            ),
//            'db.other'      => array(
//                'driver'         => 'Pdo',
//                'dsn'            => 'mysql:dbname=platform-admin;host=localhost',
//                'driver_options' => array(
//                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
//                ),
//                'username'       => 'root',
//                'password'       => '',
//            ),
        ),
    ),

    'service_manager'    => array(
        'invokables'         => array(
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
        ),
        'factories'          => array(
            'Zend\Cache\Storage' => 'Zend\Cache\Service\StorageCacheFactory',
        ),
        'aliases'            => array(
            'auth' => 'Zend\Authentication\AuthenticationService',
        ),
        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Gzfextra\Db\TableGateway\TableGatewayAbstractServiceFactory',
        )
    ),
    'view_helpers'       => array(
        'invokables' => array(
            'uri' => 'Gzfextra\View\Helper\Uri',
        ),
    ),
    'view_manager'       => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'strategies'               => array('ViewJsonStrategy'),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'ui'     => 'Gzfextra\UiFramework\Controller\Plugin\Ui',
            'get'     => 'Gzfextra\Mvc\Controller\Plugin\Get',
        )
    ),
    'caches'             => array(
        'cache'          => array(
            'adapter' => 'filesystem',
            'options' => array(
                'cacheDir' => './data/cache'
            ),
            'plugins' => array('serializer'),
        ),

//        'Cache\Persistence' => array(
//            'adapter' => 'memcache',
//            'options' => array(
//                'servers' => array(
//                    array('localhost', 11211),
//                ),
//            ),
//            'plugins' => array('serializer'),
//        ),

//        'Cache\Transient' => array(
//            'adapter' => 'filesystem',
//            'ttl'     => 60,
//            'options' => array(
//                'cacheDir' => './data/cache'
//            ),
//            'plugins' => array('serializer'),
//        ),
    ),

);
