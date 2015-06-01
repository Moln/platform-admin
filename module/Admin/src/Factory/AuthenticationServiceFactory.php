<?php

namespace Admin\Factory;

use Admin\Module;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Class AuthenticationServiceFactory
 *
 * @package Admin\Factory
 * @author  Xiemaomao
 * @version $Id$
 */
class AuthenticationServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config   = $serviceLocator->get('config')[Module::CONFIG_KEY]['authentication_adapter'];
        $adapters = $serviceLocator->get('Admin\AuthenticationAdapterPluginManagerFactory');
        $auth     = $serviceLocator->get('Zend\Authentication\AuthenticationService');

        /** @var \Zend\Authentication\AuthenticationService $auth */
        $auth->setAdapter($adapters->get(key($config), current($config)));

        return $auth;
    }
}