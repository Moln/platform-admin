<?php
namespace Moln\Admin\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use ZfcRbac\Identity\IdentityInterface;

/**
 * Class Auth
 *
 * @package Admin\Listener
 * @author  Xiemaomao
 * @version $Id: PermissionListener.php 3205 2015-04-22 10:55:55Z xiemaomao $
 */
class PermissionGuardListener extends AbstractListenerAggregate
{
    const PERMISSION_DENY = 'permission-deny';

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
        $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRouteAuth']);
    }

    public function onRouteAuth(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();

        /**
         * @var \Zend\Authentication\AuthenticationService $auth
         * @var \Zend\Permissions\Rbac\Rbac $rbac
         */
        $auth = $sm->get('auth');
        $rbac = $sm->get('Admin\Rbac');

        $roles = [];

        if ($auth->hasIdentity()) {
            $roles[] = $rbac->getRole('guest');
        } else {
            $identity = $auth->getIdentity();

            if (!$identity instanceof IdentityInterface) {
                throw new \RuntimeException('Error identity.');
            }
            $roles = $identity->getRoles();
        }

        $permission = $this->getCurrentPermission($event);

        $allow = false;
        foreach ($roles as $role) {
            if ($rbac->isGranted($role, $permission)) {
                $allow = true;
                break;
            }
        }

        if (!$allow) {
            $event->setError(self::PERMISSION_DENY);
            $event->setParam('exception', new Exception\UnauthorizedException(
                'You are not authorized to access this resource',
                403
            ));

            $event->stopPropagation(true);

            $application  = $event->getApplication();
            $eventManager = $application->getEventManager();

            $eventManager->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
        }
    }

    protected function getCurrentPermission(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();
        $routeMatch = $event->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action     = $routeMatch->getParam('action');

        /** @var \Moln\Admin\Model\RoleTable $roleTable */
        $roleTable = $sm->get('Admin\RoleTable');

        $rolePermissionResults = $roleTable->getPermissions();

        $permissions = [];
        foreach ($rolePermissionResults as $row) {
            if ($controller == $row['controller'] && $action == $row['action']) {
                return $row['permission'];
            }
        }

        return $controller . '::' . $action;
    }
}