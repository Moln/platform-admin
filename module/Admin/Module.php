<?php
namespace Admin;

use Admin\Model\RoleTable;
use Admin\Model\UserTable;
use Zend\Authentication\Storage\Session;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\ServiceManager;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRouteAuth'));
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onError'));
    }

    public function onError(MvcEvent $e)
    {
        if ($e->getError() == \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND) {
            //todo 404 not found
        }
    }

    /**
     * Login && RBAC
     * @todo permission rbac
     * @param MvcEvent $e
     */
    public function onRouteAuth(MvcEvent $e)
    {
        $matches    = $e->getRouteMatch();
        $module     = $matches->getParam('module');
        $controller = $matches->getParam('controller');
        $action     = $matches->getParam('action');
        $permission = "$module/$controller/$action";

        $sm = $e->getApplication()->getServiceManager();
        /** @var \Zend\Authentication\AuthenticationService $auth */
        $auth  = $sm->get('auth');
        $guest  = new Role('guest');
        $cache = $sm->get('cache');

        foreach ($this->getRolePermission('guest', $cache) as $r) {
            $guest->addPermission(implode('/', $r));
        }

        if (!$auth->hasIdentity()) {
            if (!$guest->hasPermission($permission) && $module != 'core') {
                header('Location: /login');
                exit();
            }
        } else {
            /** @var \Admin\Model\User $user */
            $user = $auth->getIdentity();

            $rbac = new Rbac();
            $rbac->addRole($guest);
            $allow = false;

            //Add global permission
            $guest->addPermission('admin/index/index');
            $guest->addPermission('admin/index/self');

            if ($guest->hasPermission($permission)) {
                return ;
            }

            foreach ($user->getRoles() as $role) {
                $role = new Role($role);
                $rbac->addRole($role);
                foreach ($this->getRolePermission($role->getName(), $cache) as $r) {
                    $role->addPermission(implode('/', $r));
                }
                $allow = $allow || $rbac->isGranted($role->getName(), $permission);
            }

            if (!$allow) {
                header("HTTP/1.0 403 Not Allow");
                exit;
            }
        }
    }

    /**
     * @param string $role
     * @param \Zend\Cache\Storage\Adapter\Filesystem $cache
     * @return array
     */
    public function getRolePermission($role, $cache)
    {
        $key = str_replace(array('\\', '::'), '-', __METHOD__) . '_' . $role;
        $result = $cache->getItem($key, $success);

        if (!$success) {
            $result = RoleTable::getInstance()->getPermissions($role)->toArray();
            $cache->setItem($key, $result);
            $cache->setTags($key, array('permission', 'auth', 'role'));
        }

        return $result;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories'  => array(
                'FileStorage' => '\Platform\File\Storage\StorageFactory'
            )
        );
    }
}