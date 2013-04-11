<?php
namespace System;

use System\Model\User;
use System\Model\UserTable;
use Zend\Authentication\AuthenticationService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

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
            } else {
                $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
            }
        }
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
        return array(
            'factories' => array(
                'UserTable' =>  function(ServiceManager $sm) {
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tableGateway = new TableGateway(
                        'system_user', $dbAdapter, null, $resultSetPrototype
                    );
                    return new UserTable($tableGateway);
                },
            ),
        );
    }
}
