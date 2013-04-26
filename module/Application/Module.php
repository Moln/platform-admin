<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Service\ControllerAutoLoader;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function init(ModuleManager $mm)
    {
//        $sem = $mm->getEventManager()->getSharedManager();
//        $sem->attach('application', MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));
    }

    /*
     *         $em->attach(MvcEvent::EVENT_BOOTSTRAP       , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_DISPATCH        , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR  , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_FINISH          , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_RENDER          , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_RENDER_ERROR    , array($this, 'onDispatch'));
//        $e->getApplication()->getServiceManager()->get('translator');


     * */

    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
    }

    public function onRoute(MvcEvent $e)
    {
//        $rm = $e->getRouteMatch();

        //Auto load controllers
        $controllerAutoLoader = new ControllerAutoLoader();

        /**
         * @var \Zend\Mvc\Controller\ControllerManager $controllerLoader
         */
        $controllerLoader = $e->getApplication()->getServiceManager()->get('ControllerLoader');
        $controllerLoader->addAbstractFactory($controllerAutoLoader);
    }

    public function onDispatch(MvcEvent $e)
    {
//        echo  __CLASS__ . '.' . __METHOD__ . "({$e->getName()})<br>";
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

    public function getViewManager()
    {
    }
}
