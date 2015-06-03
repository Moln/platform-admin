<?php
namespace Moln\Admin\Model;

use Gzfextra\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

/**
 * Class PermissionTable
 *
 * @package Admin\Model
 * @author
 * @version $Id: PermissionTable.php 728 2014-09-11 02:55:35Z Moln $
 *
 */
class PermissionTable extends AbstractTableGateway
{

    public function updateTitle($id, $title)
    {
        $this->update(array('title' => $title), array('per_id' => $id));
    }

    /**
     * @param string $module
     * @param string $ctrl
     * @param string $action
     * @return int
     */
    public function fetchByRule($module, $ctrl, $action)
    {
        $result = $this->select(
            function (Select $select) use ($module, $ctrl, $action) {
                $select->columns(array('per_id'));
                $select->where(array('module' => $module, 'controller' => $ctrl, 'action' => $action));
            }
        )->current();

        if ($result) {
            return (int)$result->per_id;
        } else {
            return 0;
        }
    }
}
