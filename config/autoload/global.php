<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\Authentication\Storage\Session;
use Zend\Db\Adapter\AdapterServiceFactory;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\View\Helper\Identity;
use Zend\View\HelperPluginManager;

return array(
    'db'                 => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=platform-admin;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
        'username'       => 'root',
        'password'       => '111111',
    ),
    'service_manager'    => array(
        'factories'  => array(
            'Zend\Db\Adapter\Adapter' => function ($serviceManager) {
                $adapterFactory = new AdapterServiceFactory();
                $adapter = $adapterFactory->createService($serviceManager);
                GlobalAdapterFeature::setStaticAdapter($adapter);
                return $adapter;
            },
            'Zend\Cache\Storage'      => 'Zend\Cache\Service\StorageCacheFactory',
            'Zend\Authentication\AuthenticationService' => function () {
                return new Zend\Authentication\AuthenticationService(new Session('Application_Auth'));
            }
        ),
        'aliases'    => array(
            'auth'  => 'Zend\Authentication\AuthenticationService',
            'db'    => 'Zend\Db\Adapter\Adapter',
            'cache' => 'Zend\Cache\Storage',
        ),
    ),
    'view_helpers'       => array(
        'invokables' => array(
            'uri' => 'Platform\View\Helper\Uri',
        ),
//        'factories'  => array(
//            'identity' => function (HelperPluginManager $hpm) {
//                $identity = new Identity();
//                $identity->setAuthenticationService(
//                    $hpm->getServiceLocator()->get('auth')
//                );
//                return $identity;
//            }
//        ),
    ),
    'router'             => array(
        'routes' => array(
            'home'   => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'module'     => 'core',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'module' => array(
                'type'         => 'segment',
                'options'      => array(
                    'route'       => '/:module[/][:controller[/:action]]',
                    'constraints' => array(
                        'module'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
                'child_routes' => array(
                    'method' => array(
                        'type' => 'Wildcard',
                    ),
                ),
            ),
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
            'ui'     => 'Platform\Mvc\Controller\Plugin\ui',
            'page'   => 'Platform\Mvc\Controller\Plugin\Page',
            'result' => 'Platform\Mvc\Controller\Plugin\Result',
        )
    ),
    'cache' => array(
        'adapter' => array(
            'name' => 'filesystem',
            'options' => array(
                'cacheDir' => './data/cache'
            ),
        ),
        'plugins' => array('serializer'),
    ),
);
