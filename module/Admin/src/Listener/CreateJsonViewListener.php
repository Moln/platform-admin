<?php

namespace Moln\Admin\Listener;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;


/**
 * Class CreateJsonViewListener
 * @package Moln\Admin\Listener
 * @author Xiemaomao
 * @version $Id$
 */
class CreateJsonViewListener extends AbstractListenerAggregate
{

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $se = $events->getSharedManager();
        //在 injectViewModelListener 之前, createViewModel 之后,变更 ViewModel 的 terminal 属性
        $se->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH, array($this, 'createJsonView'), -79);
    }

    public function createJsonView(MvcEvent $e)
    {
        if ($e->getResult() instanceof ViewModel) {
            $e->getResult()->setTerminal(true);
        } else if (is_array($e->getResult())) {
            $e->setResult(new JsonModel($e->getResult()));
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
}