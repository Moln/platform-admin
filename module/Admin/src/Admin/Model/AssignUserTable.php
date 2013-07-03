<?php
/**
 * platform-admin AssignUserTable.php
 * @DateTime 13-4-18 下午3:37
 */
namespace Admin\Model;

use Platform\Db\AbstractTable;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class AssignUserTable
 * @package Admin\Model
 * @author Moln Xie
 * @version $Id: AssignUserTable.php 885 2013-05-22 03:08:41Z maomao $
 */
class AssignUserTable extends AbstractTable
{
    protected $primary = array('role_id', 'user_id');
    protected $table = 'admin_assign_user_role';

    public function getRolesByUserId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('role_id'));
        $select->where(array('user_id' => $id));

        $result = $this->selectWith($select);
        $roles = array();
        foreach ($result as $row) {
            $roles[] = (int)$row['role_id'];
        }
        return $roles;
    }

    public function getRoleNamesByUserId($id)
    {
        $select = $this->sql->select();
        $select->where(array('user_id' => $id));
        $select->join(
            array('r' => RoleTable::getInstance()->getTable()),
            $this->table . '.role_id=r.role_id',
            array('name')
        );

        $result = $this->selectWith($select);
        $roles = array();
        foreach ($result as $row) {
            $roles[] = $row['name'];
        }
        return $roles;
    }

    public function getUsersByRoleId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('user_id'));
        $select->where(array('role_id' => $id));

        $result = $this->selectWith($select);
        $users = array();
        foreach ($result as $row) {
            $users[] = (int)$row['user_id'];
        }
        return $users;
    }

    public function resetUsersById($userId, array $roles)
    {
        $this->removeUserId($userId);
        foreach ($roles as $roleId) {
            $this->insert(array('role_id' => $roleId, 'user_id' => $userId));
        }
    }

    public function resetUsersByRoleId($roleId, array $users)
    {
        $this->removeRoleId($roleId);
        foreach ($users as $userId) {
            $this->insert(array('role_id' => $roleId, 'user_id' => $userId));
        }
    }

    public function removeUserId($userId)
    {
        $this->delete(array('user_id' => $userId));
    }

    public function removeRoleId($roleId)
    {
        $this->delete(array('role_id' => $roleId));
    }
}