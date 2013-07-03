<?php
/**
 * platform-admin AssignPermissionTable.php
 * @DateTime 13-4-18 下午3:37
 */

namespace Admin\Model;

use Platform\Db\AbstractTable;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class AssignPermissionTable
 * @package Admin\Model
 * @author Moln Xie
 * @version $Id: AssignPermissionTable.php 885 2013-05-22 03:08:41Z maomao $
 */
class AssignPermissionTable extends AbstractTable
{
    protected $primary = array('role_id', 'per_id');
    protected $table = 'admin_assign_role_permission';

    public function getRolesByPermissionId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('role_id'));
        $select->where(array('per_id' => $id));

        $result = $this->selectWith($select);
        $roles = array();
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

        $result = $this->selectWith($select);
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