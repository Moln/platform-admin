<?php

namespace Moln\Admin\Factory;

use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


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
        /** @var \Moln\Admin\Model\RoleTable $roleTable */
        $roleTable = $serviceLocator->get('Admin\RoleTable');

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

        return $rbac;
    }


}