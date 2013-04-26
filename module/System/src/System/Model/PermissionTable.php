<?php
/**
 * platform-admin Permission.php
 * @DateTime 13-4-18 下午3:37
 */

namespace System\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

/**
 * Class PermissionTable
 * @package System\Model
 * @author Xiemaomao
 * @version $Id$
 */
class PermissionTable extends AbstractTableGateway
{
    protected $table = 'system_permission';

    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->featureSet = new FeatureSet(array(new RowGatewayFeature('per_id')));
    }

    public function updateTitle($id, $title)
    {
        $this->update(array('title' => $title), array('per_id' => $id));
    }

    public function deleteKey($id)
    {
        $this->delete(array('per_id' => $id));
    }
}