<?php
/**
 * platform-admin Auth.php
 * @DateTime 13-11-1 上午11:03
 */

namespace Admin\Listener;

use Admin\Model\RoleTable;
use Zend\Cache\Storage\Adapter\AbstractAdapter as Cache;
use Zend\Cache\Storage\TaggableInterface;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

/**
 * Class Auth
 * @package Admin\Listener
 * @author Xiemaomao
 * @version $Id$
 */
class Auth
{

    /**
     * Login && RBAC
     *
     * @todo permission rbac
     *
     * @param MvcEvent $e
     */
    public static function onRouteAuth(MvcEvent $e)
    {
        $matches    = $e->getRouteMatch();
        $module     = $matches->getParam('module');
        $controller = $matches->getParam('controller');
        $action     = $matches->getParam('action');
        $permission = "$module.$controller.$action";

        $sm               = $e->getApplication()->getServiceManager();
        $controllerLoader = $sm->get('ControllerLoader');
        if (!$controllerLoader->has($controller)) {
            return;
        }
        if ($module == 'core') {
            return ;
        }

        /** @var \Zend\Authentication\AuthenticationService $auth */
        $auth  = $sm->get('auth');
        $cache = $sm->get('cache');
        $rbac  = self::loadRbac($cache);
        $guest = $rbac->hasRole('guest') ? $rbac->getRole('guest') : new Role('guest');

        if (!$auth->hasIdentity()) {
            if (!$guest->hasPermission($permission)) {
                header('Location: /login');
                exit();
            }
        } else {
            /** @var \Admin\Model\User $user */
            $user = $auth->getIdentity();
            $user->setRbac($rbac);

            //Add global permission
            $guest->addPermission('admin/index/index');

            if ($guest->hasPermission($permission)) {
                return;
            }

            if (!$user->isAllow($permission)) {
                header("HTTP/1.0 403 Not Allow");
                exit;
            }
        }
    }

    protected static function loadRbac(Cache $cache)
    {

        $key    = str_replace(array('\\', '::'), '-', __METHOD__);
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