<?php
/**
 * platform-admin Permission.php
 * @DateTime 13-4-18 下午3:37
 */

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

/**
 * Class PermissionTable
 * @package Admin\Model
 * @author Moln Xie
 * @version $Id: PermissionTable.php 885 2013-05-22 03:08:41Z maomao $
 */
class PermissionTable extends AbstractTableGateway
{
    protected $table = 'admin_permission';

    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->featureSet = new FeatureSet(array(new RowGatewayFeature('per_id')));
    }

    public function updateTitle($id, $title)
    {
        $this->update(array('title' => $title), array('per_id' => $id));
    }
}