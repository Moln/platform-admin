<?php
/**
 * platform-admin RoleTable.php
 * @DateTime 13-4-12 下午4:32
 */

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

/**
 * Class RoleTable
 * @package Admin\Model
 * @author Moln Xie
 * @version $Id$
 */
class RoleTable extends AbstractTableGateway
{
    protected $table = 'admin_role';
    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
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
        $adapter = new DbSelect($select, $this->getAdapter());
        return new Paginator($adapter);
    }

    public function save(array &$data)
    {
        if ($data['role_id']) {
            $updateData = array_filter($data);
            unset($updateData['role_id']);

            $result = $this->update($updateData, array('role_id' => $data['role_id']));
        } else {
            $result        = $this->insert(array_filter($data));
            $data['role_id'] = $this->getLastInsertValue();
        }
        return $result;
    }

    public function deleteKey($id)
    {
        return $this->delete(array('role_id' => $id));
    }
}