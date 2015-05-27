<?php

namespace Admin\Rbac;

use Rbac\Role\HierarchicalRole;
use Rbac\Role\Role;
use ZfcRbac\Exception\RoleNotFoundException;
use ZfcRbac\Role\RoleProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;


/**
 * Class RoleProvider
 *
 * @package Admin\Permission
 * @author  Xiemaomao
 * @version $Id$
 */
class RoleProvider implements RoleProviderInterface, ServiceLocatorAwareInterface
{
    use CacheTrait;

    protected $rolesConfig = [];

    /**
     * Get the roles from the provider
     *
     * @param  string[] $roleNames
     * @return \Rbac\Role\RoleInterface[]
     */
    public function getRoles(array $roleNames)
    {
        if (!$this->hasCache() || !$this->getCache()->hasItem('roles')) {
            $permissionResults = $this->getRoleTable()->getPermissions();

            $rolePermissions = [];
            $permissions = [];
            foreach ($permissionResults as $row) {
                $rolePermissions[$row['name']][] = $row['permission'];
                $permissions[] = $row['permission'];
            }

            $this->rolesConfig = $this->getRoleTable()->getTreeRole(
                'children',
                function ($row) use ($rolePermissions) {
                    return array(
                        'name'        => $row['name'],
                        'permissions' => $rolePermissions[$row['name']],
                    );
                }
            );

            if ($this->hasCache()) {
                $this->getCache()->setItem('permissions', $permissions);
                $this->getCache()->setItem('roles', $this->rolesConfig);
            }
        } else {
            $this->rolesConfig = $this->getCache()->getItem('roles');
        }

        $roles = [];

        foreach ($roleNames as $roleName) {
            if ($roleName == 'guest') {
                $roles[] = new Role($roleName);
                continue;
            }

            if (isset($this->rolesConfig[$roleName]['obj'])) {
                $roles[] = $this->rolesConfig[$roleName]['obj'];
                continue;
            }

            if (!isset($this->rolesConfig[$roleName])) {
                throw new RoleNotFoundException(
                    sprintf(
                        'Some roles were asked but could not be loaded from database: %s',
                        implode(', ', array_diff($roleNames, $roles))
                    )
                );
            }

            $roleConfig = $this->rolesConfig[$roleName];

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

            $roles[] = $this->rolesConfig[$roleName]['obj'] = $role;
        }

        return $roles;
    }
}