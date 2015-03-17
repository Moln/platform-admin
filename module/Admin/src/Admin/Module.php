<?php
namespace Admin;

use Admin\Listener\Operation;
use Gzfextra\Db\TableGateway\AbstractTableGateway;
use Gzfextra\Mvc\GlobalModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {

        $em = $e->getApplication()->getEventManager();
        $em->attach(new Operation());
        $em->attach(MvcEvent::EVENT_ROUTE, array('\Admin\Listener\Auth', 'onRouteAuth'), 0);
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onError'));

        //设置分页优先级要高于 controller dispatch
        $em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch100'), 100);
        $em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));
//        $em->attach(MvcEvent::EVENT_RENDER, array($this, 'onRender'));

        $em->attach(new GlobalModuleRouteListener());
        AbstractTableGateway::setServiceLocator($e->getApplication()->getServiceManager());

        $se = $e->getApplication()->getEventManager()->getSharedManager();

        //在 injectViewModelListener 之前, createViewModel 之后,变更 ViewModel 的 terminal 属性
        $se->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), -99);
    }

    public function getConfig()
    {
        return GlobalModuleRouteListener::getDefaultRouterConfig();
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
            //todo 500
        }
    }
}