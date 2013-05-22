<?php
/**
 * platform-admin AbstractTable.php
 * @DateTime 13-5-6 下午4:52
 */

namespace Platform\Db;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

/**
 * Class AbstractTable
 * @package Platform\Db
 * @author Moln Xie
 * @version $Id$
 */
abstract class AbstractTable extends AbstractTableGateway
{
    protected static $tableInstances = array();

    protected $schema;

    protected $primary = array();

    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        if ($this->schema && is_string($this->table)) {
            $this->table = new TableIdentifier($this->table, $this->schema);
        }
        $this->initialize();
    }

    /**
     *
     * @param $id
     *
     * @return array|\ArrayObject|null
     */
    public function find($id)
    {
        $where = array();
        foreach ($this->primary as $key => $primary) {
            $where[$primary] = func_get_arg($key);
        }

        return $this->select($where)->current();
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        $className = get_called_class();
        if (!isset(self::$tableInstances[$className])) {
            self::$tableInstances[$className] = new static();
        }

        return self::$tableInstances[$className];
    }

    /**
     * Fetch Paginator
     *
     * @param Select|Where|\Closure|string|array|\Zend\Db\Sql\Predicate\PredicateInterface $where
     * @param string|array $order
     * @param array        $columns
     *
     * @return Paginator
     */
    public function fetchPaginator($where = null, $order = null, $columns = null)
    {
        if ($where instanceof Select) {
            $select = $where;
        } else {
            $select = $this->getSql()->select();
            if ($where) {
                $select->where($where);
            }
            if ($columns) {
                $select->columns($columns);
            }
            if ($order) {
                $select->order($order);
            }
        }

        $adapter = new DbSelect($select, $this->getAdapter());
        return new Paginator($adapter);
    }

    /**
     * Fetch Count
     *
     * @param array|Where $where
     *
     * @return int
     */
    public function fetchCount($where = null)
    {
        $select = $this->sql->select();
        if ($where) {
            $select->where($where);
        }
        $select->columns(array('Platform_Db_Count' => new Expression('count(1)')));
        $result = $this->sql->prepareStatementForSqlObject($select)->execute()->current();
        return $result['Platform_Db_Count'];
    }

    public function save(&$data)
    {
        $insert = false;
        $temp   = $data;
        $where  = array();
        if (empty($this->primary)) {
            throw new \RuntimeException('Empty primary, can\'t use save() method.');
        }
        foreach ($this->primary as $primary) {
            if (empty($temp[$primary])) {
                $insert = true;
                break;
            }
            $where[$primary] = $temp[$primary];
            unset($temp[$primary]);
        }

        if ($insert) {
            $result         = $this->insert($data);
            $data[$primary] = $this->getLastInsertValue();
        } else {
            $result = $this->update((array) $temp, $where);
        }
        return $result;
    }

    public function deletePrimary($key)
    {
        return $this->delete(array(current($this->primary) => $key));
    }

    public function getPrimary()
    {
        return current($this->primary);
    }
}