<?php

namespace Admin\Factory;

use Admin\Authentication\AuthenticationAdapterPluginManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Module;
use Zend\ServiceManager\ServiceManagerAwareInterface;


/**
 * Class AuthAdapterPluginManagerFactory
 *
 * @package Admin\Factory
 * @author  Xiemaomao
 * @version $Id$
 */
class AuthenticationAdapterPluginManagerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $configs = $serviceLocator->get('config')[Module::CONFIG_KEY];
        $config = isset($configs['authentication_adapter_manager']) ? $configs['authentication_adapter_manager'] : [];

        $plugins = new AuthenticationAdapterPluginManager(new Config($config));

        $plugins->addInitializer(function ($instance) use ($serviceLocator) {
            if ($instance instanceof ServiceManagerAwareInterface) {
                $instance->setServiceManager($serviceLocator);
            }
        });

        return $plugins;
    }
}