<?php

namespace Moln\Admin\Listener;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;


/**
 * Class PermissionCacheListener
 * @package Moln\Admin\Listener
 * @author Xiemaomao
 * @version $Id$
 */
class PermissionCacheListener extends AbstractListenerAggregate
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
        $this->listeners[] = $events->attach('permission.init', [$this, 'clearCache']);
    }

    public function clearCache(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();
    }
}