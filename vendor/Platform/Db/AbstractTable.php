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
 * @version $Id: AbstractTable.php 1361 2014-04-09 19:38:47Z maomao $
 */
abstract class AbstractTable extends AbstractTableGateway
{
    protected static $tableInstances = array();

    protected $schema;
    protected $rowGateway;

    protected $primary = array();

    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        if ($this->schema && is_string($this->table)) {
            $this->table = new TableIdentifier($this->table, $this->schema);
        }

        if (is_string($this->primary)) {
            $this->primary = array($this->primary);
        }

        $this->initialize();
        if ($this->rowGateway === true) {
            $this->rowGateway = substr(get_class($this), 0, -5);
        }
        if ($this->rowGateway && class_exists($this->rowGateway)) {
            $rowGatewayPrototype = new $this->rowGateway(
                current($this->primary),
                $this->table,
                $this->adapter, $this->sql
            );
            $this->getResultSetPrototype()->setArrayObjectPrototype($rowGatewayPrototype);
        }
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
     * @param DbSelect|Where|\Closure|string|array $where
     *
     * @return Paginator
     */
    public function fetchPaginator($where = null)
    {
        if (!$this->isInitialized) {
            $this->initialize();
        }

        if ($where instanceof DbSelect) {
            $adapter = $where;
        } else {
            $select = $this->sql->select();

            if ($where instanceof \Closure) {
                $where($select);
            } elseif ($where !== null) {
                $select->where($where);
            }

            $adapter = new DbSelect($select, $this->getAdapter());
        }

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
        $where  = array();

        $temp   = $this->columns ? array_intersect_key($data, array_flip($this->columns)) : $data;
        if (empty($this->primary)) {
            throw new \RuntimeException('Empty primary, can\'t use save() method.');
        }
        foreach ($this->primary as $primary) {
            if (empty($temp[$primary])) {
                $insert = true;
                unset($temp[$primary]);
                break;
            }
            $where[$primary] = $temp[$primary];
            unset($temp[$primary]);
        }
//        var_dump($this->());exit;

        if ($insert) {
            $result         = $this->insert($temp);
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

    /**
     * @param array $row
     *
     * @return \ArrayObject
     */
    public function create(array $row = null)
    {
        $result = clone $this->getResultSetPrototype()->getArrayObjectPrototype();
        $row && $result->exchangeArray($row);
        return $result;
    }
}