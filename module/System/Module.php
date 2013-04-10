<?php
namespace System;

use System\Service\ControllerAutoLoader;
use Zend\Authentication\AuthenticationService;
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
        $match = explode('/', trim($e->getRequest()->getRequestUri(), '/'));
        $em = $e->getApplication()->getEventManager();
        if ($match[0] == strtolower(__NAMESPACE__)) {
            $auth = new AuthenticationService();
            if (!$auth->hasIdentity()) {
                header('Location: /login');
                exit;
            }
        }

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

        //todo permission rbac
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
}
