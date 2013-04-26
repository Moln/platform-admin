<?php
namespace System\Model;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Authentication\Adapter\DbTable as AuthDbTable;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class UserTable extends AbstractTableGateway
{

    protected $table = 'system_user';

    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }

    public static function encrypt($password)
    {
        return md5($password);
    }

    /**
     * @param $account
     * @param $password
     *
     * @return AuthDbTable
     */
    public function getAuthAdapter($account, $password)
    {
        $authAdapter = new AuthDbTable(
            $this->getAdapter(), $this->getTable(), 'account',
            'password'
        );
        $authAdapter->setIdentity($account);
        $authAdapter->setCredential(self::encrypt($password));

        return $authAdapter;
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function get($id)
    {
        $id     = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row    = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(User $data)
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

    public function deleteKey($id)
    {
        $this->delete(array('user_id' => $id));
    }

    // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @param $where
     *
     * @return Paginator
     */
    public function fetchPaginator($where = null)
    {
        $select = $this->getSql()->select();
        if ($where) {
            $select->where($where);
        }
        $select->columns(array('user_id', 'account', 'real_name', 'email', 'status'));
        $adapter = new DbSelect($select, $this->getAdapter());
        return new Paginator($adapter);
    }

    public function getTableGateway()
    {
        return $this;
    }
}