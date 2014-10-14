<?php

namespace Admin\Listener;

use Admin\Model\OperationLogTable;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;


/**
 * Class Operation
 *
 * @package Admin\Listener
 * @author  Moln
 */
class Operation implements ListenerAggregateInterface
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
        /** @var \Zend\Authentication\AuthenticationService $auth */
        $auth = $e->getApplication()->getServiceManager()->get('auth');

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

        OperationLogTable::getInstance()->insert(
            array(
                'uri'     => $uri,
                'method'  => $method,
                'ip'      => sprintf('%u', ip2long($ip)),
                'user_id' => $auth->getIdentity()->user_id,
                'param'   => json_encode($params)
            )
        );
    }
}