<?php

namespace Admin\Rbac;

use ZfcRbac\Guard\AbstractGuard;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use ZfcRbac\Guard\ProtectionPolicyTrait;


/**
 * Class PermissionsGuard
 *
 * @package Admin\Permission
 * @author  Xiemaomao
 * @version $Id$
 */
class PermissionsGuard extends AbstractGuard implements ServiceLocatorAwareInterface
{
    use CacheTrait;
    use ProtectionPolicyTrait;

    /**
     * @param  MvcEvent $event
     * @return bool
     */
    public function isGranted(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        $controller = strtolower($routeMatch->getParam('controller'));
        $action     = strtolower($routeMatch->getParam('action'));

        $permissionResults = $this->getRoleTable()->getPermissions();

        $permissions = [];
        foreach ($permissionResults as $row) {
            $permissions[$row['controller'] . '::' . $row['action']] = $row['permission'];
        }

        if (!isset($permissions[$controller . '::' . $action])) {
            return $this->protectionPolicy === self::POLICY_ALLOW;
        }

        $permission = $permissions[$controller . '::' . $action];

        /** @var \ZfcRbac\Service\AuthorizationService $authorizationService */
        $authorizationService = $this->getServiceManager()->get('ZfcRbac\Service\AuthorizationService');
        return $authorizationService->isGranted($permission);
    }
}