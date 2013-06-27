<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Core;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function init(ModuleManager $mm)
    {
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));

        $adapter = $e->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
        GlobalAdapterFeature::setStaticAdapter($adapter);
    }

    /**
     * ZF1 /module/controller/action 加载方式的路由
     * @param MvcEvent $e
     */
    public function onRoute(MvcEvent $e)
    {
        $matches    = $e->getRouteMatch();
        $module     = $matches->getParam('module');
        $controller = $matches->getParam('controller');

        if ($module && $controller) {
            /** @var \Zend\Mvc\Controller\ControllerManager $controllerLoader */
            $controllerLoader = $e->getApplication()->getServiceManager()->get('ControllerLoader');

            $ctrlClass = ucfirst($module) . '\\Controller\\';
            $ctrlClass .= str_replace(' ', '', ucwords(str_replace('-', ' ', $controller)));
            $ctrlClass .= 'Controller';
            if (class_exists($ctrlClass)) {
                $controllerLoader->setInvokableClass($controller, $ctrlClass);
            }
        }
    }

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

    public function getViewHelperConfig()
    {
    }

    public function getServiceConfig()
    {

    }
}
