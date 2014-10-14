<?php
namespace Admin\Model;

use Gzfextra\Db\TableGateway\AbstractTableGateway;

/**
 * Class AssignUserTable
 *
 * @package Admin\Model
 * @author
 * @version $Id: AssignUserTable.php 728 2014-09-11 02:55:35Z Moln $
 *
 */
class AssignUserTable extends AbstractTableGateway
{

    public function getRolesByUserId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('role_id'));
        $select->where(array('user_id' => $id));

        $result = $this->selectWith($select);
        $roles  = array();
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
        $roles  = array();
        foreach ($result as $row) {
            $roles[] = $row['name'];
        }
        return $roles;
    }

    public function getRoleIdsByUserId($id)
    {
        $select = $this->sql->select();
        $select->where(array('user_id' => $id));
        $select->join(
            array('r' => RoleTable::getInstance()->getTable()),
            $this->table . '.role_id=r.role_id',
            array('role_id')
        );

        $result = $this->selectWith($select);

        $roles = array();
        foreach ($result as $row) {
            $roles[] = intval($row['role_id']);
        }
        return $roles;
    }

    public function getUsersByRoleId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('user_id'));
        $select->where(array('role_id' => $id));

        $result = $this->selectWith($select);
        $users  = array();
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
