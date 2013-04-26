<?php
namespace System;

use Zend\Authentication\AuthenticationService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\Identity;
use Zend\View\HelperPluginManager;

class Module
{

    public function init(ModuleManager $mm)
    {
    }

    public function onBootstrap(MvcEvent $e)
    {
        $match = explode('/', trim($e->getRequest()->getRequestUri(), '/'));
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        if ($match[0] == strtolower(__NAMESPACE__)) {
            $auth = $sm->get('AuthenticationService');
            if (!$auth->hasIdentity()) {
                header('Location: /login');
                exit;
            } else {
                $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
            }
        }
        $adapter = $e->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
        GlobalAdapterFeature::setStaticAdapter($adapter);
    }

    /**
     * @todo permission rbac
     * @param MvcEvent $e
     */
    public function onRoute(MvcEvent $e)
    {

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

    public function getServiceConfig()
    {
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'identity' => function (HelperPluginManager $hpm) {
                    $identity = new Identity();
                    $identity->setAuthenticationService(
                        $hpm->getServiceLocator()->get('AuthenticationService')
                    );
                    return $identity;
                }
            ),
        );
    }
}
