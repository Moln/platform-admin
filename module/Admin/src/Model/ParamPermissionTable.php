<?php
namespace Moln\Admin\Model;

use Gzfextra\Db\TableGateway\AbstractTableGateway;

/**
 * Class ParamPermissionTable
 *
 * @package Admin\Model
 * @author  Lijun
 * @version $Id: ParamPermissionTable.php 728 2014-09-11 02:55:35Z xiemaomao $
 *
 */
class ParamPermissionTable extends AbstractTableGateway
{

    public function getProductsByRoleId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('param_value'));
        $select->where(array('role_id' => $id, 'per_id' => 55));

        $result   = $this->selectWith($select);
        $products = array();
        foreach ($result as $row) {
            $products[] = (int)$row['param_value'];
        }
        return $products;
    }

    public function resetProductsByRoleId($roleId, array $products)
    {
        $this->removeRoleId($roleId);
        foreach ($products as $product_id) {
            $this->insert(
                array('per_id' => 55, 'role_id' => $roleId, 'param_key' => 'product_id', 'param_value' => $product_id)
            );
        }
    }

    public function removeRoleId($roleId)
    {
        $this->delete(array('per_id' => 55, 'role_id' => $roleId, 'param_key' => 'product_id',));
    }
}
