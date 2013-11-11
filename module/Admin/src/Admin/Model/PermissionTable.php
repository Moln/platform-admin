<?php
/**
 * platform-admin Permission.php
 * @DateTime 13-4-18 下午3:37
 */

namespace Admin\Model;

use Platform\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class PermissionTable
 * @package Admin\Model
 * @author Moln Xie
 * @version $Id: PermissionTable.php 885 2013-05-22 03:08:41Z maomao $
 */
class PermissionTable extends AbstractTable
{
    protected $primary = 'per_id';
    protected $table = 'admin_permission';
    protected $rowGateway = 'Zend\Db\RowGateway\RowGateway';

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
        $result = $this->select(function (Select $select) use ($module, $ctrl, $action) {
            $select->columns(array('per_id'));
            $select->where(array('module' => $module, 'controller' => $ctrl, 'action' => $action));
        })->current();

        if ($result) {
            return (int) $result->per_id;
        } else {
            return 0;
        }
    }
}