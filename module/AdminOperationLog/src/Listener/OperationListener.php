<?php

namespace Moln\Admin\OperationLog\Listener;

use Admin\Model\OperationLogTable;
use Zend\Db\Sql\Predicate\Expression;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;


/**
 * Class Operation
 *
 * @package Admin\Listener
 * @author  Xiemaomao
 * @version $Id$
 */
class OperationListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

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
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
    }


    public function onRoute(MvcEvent $e)
    {
        $rm = $e->getRouteMatch();
        if (substr($rm->getMatchedRouteName(), 0, 6) != 'module') {
            return;
        }

        /** @var \Zend\Authentication\AuthenticationService $auth */
        $auth = $e->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService');

        if (!$auth->hasIdentity()) {
            return;
        }

        $route = $e->getRouteMatch();

        $uri = "{$route->getParam('module')}.{$route->getParam('controller_name')}.{$route->getParam('action')}";

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $e->getRequest();

        $method = $request->getMethod();
        $ip     = $request->getServer()->get("REMOTE_ADDR");

        $routeParams = $route->getParams();

        unset($routeParams['controller']);
        unset($routeParams['action']);
        unset($routeParams['module']);
        unset($routeParams['controller_name']);

        $params = array(
            'get'   => $_GET,
            'post'  => $_POST,
            'route' => $routeParams,
        );
    }
}