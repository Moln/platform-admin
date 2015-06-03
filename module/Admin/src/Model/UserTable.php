<?php
namespace Moln\Admin\Model;

use Zend\Authentication\Adapter\DbTable;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class UserTable
 *
 * @package Admin\Model
 * @author
 * @version $Id: UserTable.php 728 2014-09-11 02:55:35Z Moln $
 *
 * @method User create(array $row = null)
 */
class UserTable extends TableGateway
{

    public static function encrypt($password)
    {
        return md5($password);
    }

    /**
     * @param $account
     * @param $password
     *
     * @return DbTable\CredentialTreatmentAdapter
     */
    public function getAuthAdapter($account, $password)
    {
        $authAdapter = new DbTable\CredentialTreatmentAdapter(
            $this->getAdapter(), $this->getTable(), 'account',
            'password'
        );
        $authAdapter->setIdentity($account);
        $authAdapter->setCredential(self::encrypt($password));

        return $authAdapter;
    }

    /**
     * 更新不允许修改账号
     *
     * @param $data
     *
     * @return int
     */
    public function save(&$data)
    {
        $account = null;
        if (!empty($data['user_id'])) {
            $account = $data['account'];
            unset($data['account']);
        }
        $result = parent::save($data);
        if ($account) {
            $data['account'] = $account;
        }
        return $result;
    }
}
