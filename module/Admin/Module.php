<?php
namespace Admin;

use Admin\Model\RoleTable;
use Admin\Model\UserTable;
use Zend\Authentication\Storage\Session;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Paginator\Paginator;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\ServiceManager;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_ROUTE, array('\Admin\Listener\Auth', 'onRouteAuth'), 0);
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onError'));

        //设置分页优先级要高于 controller dispatch
        $em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), 100);
    }

    public function onError(MvcEvent $e)
    {
        if ($e->getError() == \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND) {
            //todo 404 not found
            //$e->getViewModel()->setTerminal(true);
        } else {
            //todo 500
        }
    }

    public function onDispatch(MvcEvent $e)
    {
        Paginator::setDefaultItemCountPerPage(20);
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