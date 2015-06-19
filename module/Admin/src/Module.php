<?php
namespace Moln\Admin;

use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Stdlib\ArrayUtils;

class Module
{
    const CONFIG_KEY = 'moln_admin';

    public function init(ModuleManager $manager)
    {
        $manager->getEventManager()->attach(
            ModuleEvent::EVENT_MERGE_CONFIG, function (ModuleEvent $event) {
            /** @var \Zend\ModuleManager\Listener\ConfigListener $configListener */
            $configListener = $event->getParam('configListener');
            $configs        = $configListener->getMergedConfig(false);

            $configs['service_manager']['abstract_factories'] =
                array_unique($configs['service_manager']['abstract_factories']);

            $configListener->setMergedConfig($configs);
        }
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}