<?php
/**
 * platform-admin MenuTable.php
 * @DateTime 13-8-23 下午5:29
 */

namespace Admin\Model;
use Platform\Db\AbstractTable;
use Zend\Config\Factory as ConfigFactory;
use Zend\Db\TableGateway\Feature;

/**
 * Class MenuTable
 * @package Admin\Model
 * @author Xiemaomao
 * @version $Id$
 */
class MenuTable //extends AbstractTable
{
//    protected $primary = 'menu_id';
//    protected $table = 'admin_menu';
//    protected $columns = array(
//        'menu_id',
//        'parent_id',
//        'parents',
//        'name',
//        'order',
//        'url',
//        'per_id',
//    );

//    public function __construct()
//    {
//        $this->featureSet = new Feature\FeatureSet();
//        $this->featureSet->addFeature(new Feature\MetadataFeature());
//
//        parent::__construct();
//    }

    protected static $file = 'data/configs/menu.php';

    public static function update(array $data)
    {
        /** @var \Closure $loopFilter */
        $loopFilter = null;
        $loopFilter = function ($data) use (&$loopFilter) {
            foreach ($data as $key => $item) {
                $data[$key] = array(
                    'text' => $item['text'],
                    'index' => $item['index'],
                );
                if (!empty($item['url']))        $data[$key]['url']        = $item['url'];
                if (!empty($item['permission'])) $data[$key]['permission'] = $item['permission'];
                if (!empty($item['expanded']))   $data[$key]['expanded']   = $item['expanded'];

                if (isset($item['items'])) {
                    $data[$key]['items'] = $loopFilter($item['items']);
                }
            }
            return $data;
        };

        $data = $loopFilter($data);

        return ConfigFactory::toFile(self::$file, $data);
    }

    public static function getData()
    {
        if (!file_exists(self::$file)) {
            return array(
                array('text' => '系统', 'items' => array(
                    array('text' => '修改密码', 'url' => '/admin/index/self'),
                    array('text' => '用户管理', 'url' => '/admin/user'),
                    array('text' => '角色管理', 'url' => '/admin/user'),
                    array('text' => '权限管理', 'url' => '/admin/permission'),
                )),
            );
        }
        return ConfigFactory::fromFile(self::$file);
    }
}