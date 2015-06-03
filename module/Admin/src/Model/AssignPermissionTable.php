<?php
namespace Moln\Admin\Model;

use Gzfextra\Db\TableGateway\AbstractTableGateway;

/**
 * Class AssignPermissionTable
 *
 * @package Admin\Model
 * @author
 * @version $Id: AssignPermissionTable.php 728 2014-09-11 02:55:35Z Moln $
 *
 */
class AssignPermissionTable extends AbstractTableGateway
{

    public function getRolesByPermissionId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('role_id'));
        $select->where(array('per_id' => $id));

        $result = $this->selectWith($select);
        $roles  = array();
        foreach ($result as $row) {
            $roles[] = (int)$row['role_id'];
        }
        return $roles;
    }

    public function getPermissionsByRoleId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('per_id'));
        $select->where(array('role_id' => $id));

        $result      = $this->selectWith($select);
        $permissions = array();
        foreach ($result as $row) {
            $permissions[] = (int)$row['per_id'];
        }
        return $permissions;
    }

    public function resetPermissionsById($permissionId, array $roles)
    {
        $this->delete(array('per_id' => $permissionId));
        foreach ($roles as $roleId) {
            $this->insert(array('role_id' => $roleId, 'per_id' => $permissionId));
        }
    }

    public function resetPermissionsByRoleId($roleId, array $permissions)
    {
        $this->delete(array('role_id' => $roleId));
        foreach ($permissions as $permissionId) {
            $this->insert(array('role_id' => $roleId, 'per_id' => $permissionId));
        }
    }

    public function removeRoleId($roleId)
    {
        $this->delete(array('role_id' => $roleId));
    }
}
