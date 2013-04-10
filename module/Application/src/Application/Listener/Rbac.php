<?php
/**
 * platform-admin Rbac.php
 * @DateTime 13-4-8 下午1:00
 */

namespace Application\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

/**
 * Class Rbac
 * @package Application\Listener
 * @author Xiemaomao
 * @version $Id$
 */
class Rbac implements ListenerAggregateInterface
{

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        // TODO: Implement attach() method.
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        // TODO: Implement detach() method.
    }
}