<?php

namespace Moln\Admin\Rbac;

use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use ZfcRbac\Guard\AbstractGuard;
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
    use ServiceLocatorTrait;
    use ProtectionPolicyTrait;

    protected $routes = [];

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     * @return $this
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
        return $this;
    }

    /**
     * @param  MvcEvent $event
     * @return bool
     */
    public function isGranted(MvcEvent $event)
    {

        $routeMatch = $event->getRouteMatch();
        $matchedRouteName  = $routeMatch->getMatchedRouteName();

        //验证路由规则, 是否需要权限验证
        $inRule = false;
        foreach ($this->routes as $routeRule) {
            if (fnmatch($routeRule, $matchedRouteName, FNM_CASEFOLD)) {
                $inRule = true;
                break;
            }
        }

        if (!$inRule) {
            return true;
        }

        //权限验证
        $controller = strtolower($routeMatch->getParam('controller'));
        $action     = strtolower($routeMatch->getParam('action'));

        $permissionResults = $this->getRoleTable()->getPermissions();

        $permissions = [];
        foreach ($permissionResults as $row) {
            $permissions[$row['controller'] . '::' . $row['action']] = $row['permission'];
        }

        if (!isset($permissions[$controller . '::' . $action])) {
            return $this->getProtectionPolicy() === self::POLICY_ALLOW;
        }

        $permission = $permissions[$controller . '::' . $action];

        /** @var \ZfcRbac\Service\AuthorizationService $authorizationService */
        $authorizationService = $this->getServiceManager()->get('ZfcRbac\Service\AuthorizationService');
        return $authorizationService->isGranted($permission);
    }
}