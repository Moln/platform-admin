<?php
namespace Admin;

use Gzfextra\Db\TableGateway\AbstractTableGateway;
use Gzfextra\Router\GlobalModuleRouteListener;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Paginator\Paginator;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\ViewModel;

class Module
{
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


    public function onBootstrap(MvcEvent $e)
    {
        $sm      = $e->getApplication()->getServiceManager();
        $configs = $sm->get('config');

        if (isset($configs['ini_set'])) foreach ($configs['ini_set'] as $key => $val) {
            $val !== null && ini_set($key, $val);
        }

        AbstractTableGateway::setServiceLocator($e->getApplication()->getServiceManager());

        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onError'));

        //设置分页优先级要高于 controller dispatch
        $em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch100'), 100);
        $em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));

        $se = $e->getApplication()->getEventManager()->getSharedManager();

        //在 injectViewModelListener 之前, createViewModel 之后,变更 ViewModel 的 terminal 属性
        $se->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), -99);

    }

    public function onDispatch100(MvcEvent $event)
    {
        Paginator::setDefaultItemCountPerPage(20);
    }

    public function onDispatch(MvcEvent $e)
    {
        if (substr($e->getRouteMatch()->getMatchedRouteName(), 0, 6) != 'module') {
            return;
        }

        if ($e->getResult() instanceof ViewModel) {
            $e->getResult()->setTerminal(true);
        }
//        $routeMatch = $e->getRouteMatch();
//        if (strcasecmp($routeMatch->getParam('module'), 'service') === 0) {
//            $result = $e->getResult();
//            if (is_array($result)) {
//                $e->setResult(new JsonModel($result));
//            } else {
//                $e->setResult(new JsonModel($result->getVariables()));
//            }
//            $e->setViewModel($e->getResult());
//        }
//        $e->stopPropagation(true);
    }

    public function onError(MvcEvent $e)
    {
        if ($e->getError() == \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND) {
            //todo 404 not found
            //$e->getViewModel()->setTerminal(true);
        } else {
            error_log($e->getParam('exception'), 3, 'data/exception.log');
        }
    }

    public function getConfig()
    {
        $config = include __DIR__ . '/../../config/module.config.php';
        return ArrayUtils::merge(GlobalModuleRouteListener::getDefaultRouterConfig(), $config);
    }
}