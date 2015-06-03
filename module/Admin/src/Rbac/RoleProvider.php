<?php

namespace Moln\Admin\Rbac;

use Rbac\Role\HierarchicalRole;
use Rbac\Role\Role;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use ZfcRbac\Exception\RoleNotFoundException;
use ZfcRbac\Role\RoleProviderInterface;


/**
 * Class RoleProvider
 *
 * @package Admin\Permission
 * @author  Xiemaomao
 * @version $Id$
 */
class RoleProvider implements RoleProviderInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorTrait;

    protected $rolesConfig;

    /**
     * Get the roles from the provider
     *
     * @param  string[] $roleNames
     * @return \Rbac\Role\RoleInterface[]
     */
    public function getRoles(array $roleNames)
    {
        $rolesConfig = $this->getRolesConfig();

        $roles = [];

        foreach ($roleNames as $roleName) {
            if ($roleName == 'guest') {
                $roles[] = new Role($roleName);
                continue;
            }

            if (isset($rolesConfig[$roleName]['obj'])) {
                $roles[] = $rolesConfig[$roleName]['obj'];
                continue;
            }

            if (!isset($rolesConfig[$roleName])) {
                throw new RoleNotFoundException(
                    sprintf(
                        'Some roles were asked but could not be loaded from database: %s',
                        implode(', ', array_diff($roleNames, $roles))
                    )
                );
            }

            $roleConfig = $rolesConfig[$roleName];

            if (isset($roleConfig['children'])) {
                $role       = new HierarchicalRole($roleName);
                $childRoles = (array)$roleConfig['children'];

                foreach ($this->getRoles($childRoles) as $childRole) {
                    $role->addChild($childRole);
                }
            } else {
                $role = new Role($roleName);
            }

            $permissionResults = isset($roleConfig['permissions']) ? $roleConfig['permissions'] : [];

            foreach ($permissionResults as $permission) {
                $role->addPermission($permission);
            }

            $roles[] = $rolesConfig[$roleName]['obj'] = $role;
        }

        return $roles;
    }

    public function getRolesConfig()
    {
        if (!$this->rolesConfig) {
            $permissionResults = $this->getRoleTable()->getPermissions();

            $rolePermissions = [];
            foreach ($permissionResults as $row) {
                $rolePermissions[$row['name']][] = $row['permission'];
            }

            $this->rolesConfig = $this->getRoleTable()->getTreeRole(
                'name',
                'children',
                function ($row) use ($rolePermissions) {
                    return array(
                        'name'        => $row['name'],
                        'permissions' => isset($rolePermissions[$row['name']]) ? $rolePermissions[$row['name']] : [],
                    );
                }
            );
        }

        return $this->rolesConfig;
    }
}