<?php
namespace Admin\Model;

use Platform\Db\AbstractTable;
use Zend\Authentication\Adapter\DbTable;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Paginator\Paginator;

/**
 * Class UserTable
 * @package Admin\Model
 * @author Xiemaomao
 * @version $Id$
 *
 * @method User create()
 */
class UserTable extends AbstractTable
{
    protected $primary = 'user_id';
    protected $table = 'admin_user';

    protected $rowGateway = true;

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