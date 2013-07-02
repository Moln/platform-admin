<?php
namespace Admin\Model;

use Platform\Db\AbstractTable;
use Zend\Authentication\Adapter\DbTable;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Paginator\Paginator;

class UserTable extends AbstractTable
{
    protected $primary = 'user_id';
    protected $table = 'admin_user';

    protected $rowGateway = 'Admin\\Model\\User';

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

    public function save(&$data)
    {
        if (!empty($data['user_id'])) {
            unset($data['account']);
        }
        return parent::save($data);
    }
}