<?php
/**
 * platform-admin RoleTable.php
 * @DateTime 13-4-12 下午4:32
 */

namespace Admin\Model;

use Platform\Db\AbstractTable;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Paginator\Paginator;

/**
 * Class RoleTable
 * @package Admin\Model
 * @author Moln Xie
 * @version $Id: RoleTable.php 885 2013-05-22 03:08:41Z maomao $
 */
class RoleTable extends AbstractTable
{
    protected $primary = 'role_id';
    protected $table = 'admin_role';

    /**
     * 查询角色权限
     * @param $role
     *
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPermissionsByRole($role)
    {
        $select = $this->sql->select();
        $select->columns(array());
        $select->join(
            'admin_assign_role_permission',
            'admin_role.role_id=admin_assign_role_permission.role_id',
            array()
        );
        $select->join(
            'admin_permission',
            'admin_assign_role_permission.per_id=admin_permission.per_id',
            array('module', 'controller', 'action')
        );

        $select->where(array('name' => $role));
        return $this->selectWith($select);
    }

    /**
     * 获取所有角色关联权限
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPermissions()
    {
        $select = $this->sql->select();
        $select->columns(array('name'));
        $select->join(
            'admin_assign_role_permission',
            'admin_role.role_id=admin_assign_role_permission.role_id',
            array()
        );
        $select->join(
            'admin_permission',
            'admin_assign_role_permission.per_id=admin_permission.per_id',
            array('module', 'controller', 'action')
        );
        return $this->selectWith($select);
    }
}