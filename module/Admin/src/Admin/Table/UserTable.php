<?php
namespace Admin\Table;

use Admin\Model\User;
use Platform\Db\AbstractTable;
use Zend\Authentication\Adapter\DbTable;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Paginator\Paginator;

class UserTable extends AbstractTable
{
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
        if ($data->user_id) {
            $updateData = array_filter($data->getArrayCopy());
            unset($updateData['user_id']);
            unset($updateData['account']);

            $result = $this->update($updateData, array('user_id' => $data->user_id));
        } else {
            $result        = $this->insert(array_filter($data->getArrayCopy()));
            $data->user_id = $this->getLastInsertValue();
        }
        return $result;
    }
}