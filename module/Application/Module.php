<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Db\TableGateway\TableGateway;
use System\Model\User;
use Zend\Db\ResultSet\ResultSet;
use System\Model\UserTable;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\MvcEvent;

class Module
{
    public function init(ModuleManager $mm)
    {
        echo  __CLASS__ . '.' . __METHOD__ . "<br>";
        $sem = $mm->getEventManager()->getSharedManager();
        $sem->attach('application', MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));
    }

    public function onBootstrap(MvcEvent $e)
    {
        echo  __CLASS__ . '.' . __METHOD__ . "({$e->getName()})<br>";

        $rl = $e->getApplication();

        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_BOOTSTRAP       , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_DISPATCH        , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR  , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_FINISH          , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_RENDER          , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_RENDER_ERROR    , array($this, 'onDispatch'));
        $em->attach(MvcEvent::EVENT_ROUTE           , array($this, 'onDispatch'));
//        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function onDispatch(MvcEvent $e)
    {
        echo  __CLASS__ . '.' . __METHOD__ . "({$e->getName()})<br>";
    }


    public function getConfig()
    {
        echo  __CLASS__ . '.' . __METHOD__ . '<br>';
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        echo  __CLASS__ . '.' . __METHOD__ . '<br>';
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
        echo  __CLASS__ . '.' . __METHOD__ . '<br>';
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

    public function getViewManager()
    {
        echo  __CLASS__ . '.' . __METHOD__ . '<br>';
    }
}
