<?php
namespace Moln\Admin\Model;

use Moln\Admin\Identity\UserIdentity;
use Zend\Authentication\Adapter\DbTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class UserTable
 *
 * @package Admin\Model
 * @author
 * @version $Id: UserTable.php 728 2014-09-11 02:55:35Z Moln $
 *
 */
class UserTable extends TableGateway
{

    public static function encrypt($password)
    {
        return md5($password);
    }

    /**
     * 更新不允许修改账号
     *
     * @param UserIdentity $user
     *
     * @return int
     */
    public function updateIdentity(UserIdentity $user)
    {
        $this->update($this->getIdentityModifyFields($user), ['user_id' => $user->getUserId()]);
    }

    /**
     * @param UserIdentity $user
     * @return array
     */
    private function getIdentityModifyFields(UserIdentity $user)
    {
        $data = (new ClassMethods)->extract($user);
        unset($data['user_id'], $data['account'], $data['roles']);

        return $data;
    }
}
