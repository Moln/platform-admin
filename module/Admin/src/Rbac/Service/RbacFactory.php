<?php

namespace Admin\Rbac\Service;
use Admin\Module;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\StorageFactory;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Permissions\Rbac\Rbac;


/**
 * Class RbacFactory
 * @package Admin\Service
 * @author Xiemaomao
 * @version $Id$
 */
class RbacFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        /** @var \Admin\Model\RoleTable $roleTable */
        $roleTable = $serviceLocator->get('Admin\RoleTable');

        if (isset($config[Module::CONFIG_KEY]['permission_cache'])) {
            $cacheConfig = $config[Module::CONFIG_KEY]['permission_cache'];

            if (is_string($cacheConfig)) {
                $cache = $serviceLocator->get($cacheConfig);
            } else if (is_array($cacheConfig)) {
                $cache = StorageFactory::factory($cacheConfig);
            }

            if (!isset($cache) || !$cacheConfig instanceof StorageInterface) {
                throw new \RuntimeException('RbacFactory config error.');
            }

            $rolePermissionResults = $cache->getItem('permissions');
            if ($rolePermissionResults) {
                $roleTable->setPermissions($rolePermissionResults);
            }

            $rbac = $cache->getItem('rbac');

            if ($rbac instanceof Rbac) {
                return $rbac;
            }
        }

        $rolePermissionResults = $roleTable->getPermissions();
        $rolePermissions = [];
        $permissions = [];
        foreach ($rolePermissionResults as $row) {
            $rolePermissions[$row['name']][] = $row['permission'];
            $permissions[$row['controller'] . '::' . $row['action']] = $row['permission'];
        }

        $rbac = new Rbac();

        $roles = $roleTable->getTreeRole(
            'children',
            function ($row) use ($rolePermissions, $rbac) {
                $role = new Role($row['name']);
                $rbac->addRole($role);

                foreach ($rolePermissions[$row['name']] as $permission) {
                    $role->addPermission($permission);
                }

                return [
                    'role' => $role
                ];
            }
        );

        foreach ($roles as $key => $role) {
            if ($key === 0) {
                continue;
            }

            if (isset($role['children'])) {
                foreach ($role['children'] as $child) {
                    $role['role']->addChild($child);
                }
            }
        }

        if (!$rbac->hasRole('guest')) {
            $rbac->addRole('guest');
        }

        if (isset($cache)) {
            $cache->setItem('rbac', $rbac);
            $cache->setItem('permissions', $rolePermissionResults);
        }

        return $rbac;
    }


}