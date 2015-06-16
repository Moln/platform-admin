<?php

namespace Moln\ModelManager\DataSource;
use Gzfextra\Stdlib\OptionsTrait;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;


/**
 * Class AbstractTableGatewayDataSource
 * @package Moln\ModelManager\DataSource
 * @author Xiemaomao
 * @version $Id$
 */
abstract class AbstractDbAdapterDataSource implements DataSourceInterface
{
    use OptionsTrait;

    const DRIVER = 'pdo_mysql';

    protected $driverOptions = [];
    protected $metadata;
    protected $dbAdapter;


    public function __construct($options)
    {
        $this->setOptions($options);
    }

    /**
     * @return array
     */
    public function getDriverOptions()
    {
        return $this->driverOptions;
    }

    /**
     * @param array $driverOptions
     * @return $this
     */
    public function setDriverOptions(array $driverOptions)
    {
        $driverOptions = array_filter($driverOptions);
        $this->driverOptions = $driverOptions;
        return $this;
    }

    /**
     * @return Adapter
     */
    public function getDbAdapter()
    {
        if (!$this->dbAdapter) {
            $adapter = new Adapter(['driver' => static::DRIVER] + $this->getDriverOptions());
            $this->setDbAdapter($adapter);
        }
        return $this->dbAdapter;
    }

    /**
     * @param mixed $dbAdapter
     * @return $this
     */
    public function setDbAdapter($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }


    public function getMetadata()
    {
        if (!$this->metadata) {

            $metadata = new Metadata($this->getDbAdapter());
            $this->metadata = $metadata;
        }

        return $this->metadata;
    }

    public function getTables()
    {
        $tables = [];
        foreach ($this->getMetadata()->getTables() as $table) {
            foreach ($table->getColumns() as $column) {
                $tables[$table->getName()][] = $column->getName();
            }
        }

        return $tables;
    }

    /**
     * @param Where|array $where
     * @return Paginator
     */
    public function read($where = null)
    {
        $config = $this->dataConfig;
        if ($config['query_type'] == 'normal') {
            $table = new TableGateway($config['table'], $this->getDbAdapter());

            $columns = [];
            foreach ($config['column_enable'] as $column => $enable) {
                if ($enable) {
                    $alias = $config['column_alias'][$column] ? : $column;

                    $columns[$alias] = $column;
                }
            }

            $select = $table->getSql()->select();
            $select->columns($columns);
            if (!empty($where)) {
                $select->where($where);
            }

            return new Paginator($adapter = new DbSelect($select, $this->getDbAdapter()));
        } else {
            $params = [];
            if (!empty($where)) {
                $whereData = $where->getExpressionData();
                foreach ($whereData as $key => $val) {
                    //todo fix sql mode
                }
            }
            return $this->getDbAdapter()->query($config['sql'], $params)->toArray();
        }
    }

    protected $dataConfig;

    public function setDataConfig(array $config)
    {
        $this->dataConfig = $config;
    }
}