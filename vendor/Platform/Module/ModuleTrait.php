<?php
/**
 * platform-admin AbstractModule.php
 * @DateTime 13-5-3 下午1:26
 */

namespace Platform\Module;

/**
 * Class AbstractModule
 * @package Platform\Module
 * @author Moln Xie
 * @version $Id$
 */
trait ModuleTrait
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}