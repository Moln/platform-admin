<?php
namespace Admin\Listener;

use Admin\Model\RoleTable;
use Zend\Cache\Storage\Adapter\AbstractAdapter as Cache;
use Zend\Cache\Storage\TaggableInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

/**
 * Class Auth
 *
 * @package Admin\Listener
 * @author  Xiemaomao
 * @version $Id: PermissionListener.php 3205 2015-04-22 10:55:55Z xiemaomao $
 */
class PermissionListener extends AbstractListenerAggregate
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
        $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRouteAuth']);
    }

    /**
     * Login && RBAC
     *
     * @todo permission rbac
     *
     * @param MvcEvent $e
     */
    public function onRouteAuth(MvcEvent $e)
    {
        $rm = $e->getRouteMatch();
        if (substr($rm->getMatchedRouteName(), 0, 6) != 'module') {
            return;
        }

        $sm               = $e->getApplication()->getServiceManager();
        $controllerLoader = $sm->get('ControllerLoader');
        if (!$controllerLoader->has($rm->getParam('controller'))) {
            return;
        }

        $module     = $rm->getParam('module');
        $controller = $rm->getParam('__CONTROLLER__');
        $action     = $rm->getParam('action');
        $permission = "$module.$controller.$action";

        /** @var \Zend\Authentication\AuthenticationService $auth */
        $auth  = $sm->get('auth');
        $cache = $sm->get('cache.permission');
        $rbac  = $this->loadRbac($cache);
        $guest = $rbac->hasRole('Guest') ? $rbac->getRole('Guest') : new Role('Guest');

        if (!$auth->hasIdentity()) {
            if (!$guest->hasPermission($permission)) {
                header('Location: ' . $e->getRouter()->assemble([], ['name' => 'login']));
                exit();
            }
        } else {
            /** @var \Admin\Model\User $user */
            $user = $auth->getIdentity();
            $user->setRbac($rbac);

            //Add global permission
            $guest->addPermission('admin.index.index');

            if ($guest->hasPermission($permission)) {
                return;
            }

            if (!$user->isAllow($permission)) {
                header("HTTP/1.0 403 Not Allow");
                exit;
            }
        }
    }

    protected function loadRbac(Cache $cache)
    {

        $key  = 'rbac';
        $rbac = $cache->getItem($key, $success);

        if ($success) {
            return $rbac;
        }

        $rbac = new Rbac();

        $data  = RoleTable::getInstance()->getPermissions();
        $roles = array();
        foreach ($data as $row) {
            if (isset($roles[$row['name']])) {
                $roles[$row['name']]->addPermission($row['module'] . '.' . $row['controller'] . '.' . $row['action']);
            } else {
                $role = new Role($row['name']);
                $role->addPermission($row['module'] . '.' . $row['controller'] . '.' . $row['action']);
                $rbac->addRole($role);

                $roles[$row['name']] = $role;
            }
        }

        $cache->setItem($key, $rbac);
        if ($cache instanceof TaggableInterface) {
            $cache->setTags($key, array('permission', 'auth', 'role'));
        }

        return $rbac;
    }

}