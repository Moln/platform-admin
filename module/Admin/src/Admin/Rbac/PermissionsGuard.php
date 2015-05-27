<?php

namespace Admin\Rbac;
use ZfcRbac\Guard\AbstractGuard;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorAwareInterface;


/**
 * Class PermissionsGuard
 * @package Admin\Permission
 * @author Xiemaomao
 * @version $Id$
 */
class PermissionsGuard extends AbstractGuard implements ServiceLocatorAwareInterface
{
    use CacheTrait;

    /**
     * @param  MvcEvent $event
     * @return bool
     */
    public function isGranted(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        $controller = strtolower($routeMatch->getParam('controller'));
        $action     = strtolower($routeMatch->getParam('action'));

        if (!$this->hasCache() || !$this->getCache()->hasItem('roles')) {
            $permissionResults = $this->getRoleTable()->getPermissions();

            $permissions = [];
            foreach ($permissionResults as $row) {
                $permissions[] = $row['permission'];
            }

            if ($this->hasCache()) {
                $this->getCache()->setItem('permissions', $permissions);
            }
        } else {
            $permission = $this->getCache()->getItem('roles');
        }

//            if (!$this->authorizationService->isGranted($permission)) {
//                return false;
//            }

        return true;
    }
}