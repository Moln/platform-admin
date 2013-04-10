<?php
namespace System\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Authentication\Adapter\DbTable as AuthDbTable;

class UserTable
{
    protected $tableGateway;

    public static function encrypt($password)
    {
        return md5($password);
    }

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
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
            $this->tableGateway->getAdapter(),
            $this->tableGateway->getTable(),
            'account',
            'password'
        );
        $authAdapter->setIdentity($account);
        $authAdapter->setCredential(self::encrypt($password));

        return $authAdapter;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function get($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(User $album)
    {
    }

    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}