<?php

namespace Moln\ModelManager\DataSource;
use Gzfextra\Stdlib\OptionsTrait;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;


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

    public function getMetadata()
    {
        if (!$this->metadata) {

            $adapter = new Adapter(['driver' => static::DRIVER] + $this->getDriverOptions());
            $metadata = new Metadata($adapter);
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
}