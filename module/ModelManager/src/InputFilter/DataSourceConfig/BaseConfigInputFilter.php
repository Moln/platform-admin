<?php

namespace Moln\ModelManager\InputFilter\DataSourceConfig;

use Zend\InputFilter\InputFilter;


/**
 * Class BaseConfigInputFilter
 *
 * @package Moln\ModelManager\InputFilter
 * @author  Xiemaomao
 * @version $Id$
 */
class BaseConfigInputFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(
            [
                'name'    => 'name',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
        $this->add(
            [
                'name'       => 'adapter',
                'validators' => [
                    [
                        'name'    => 'InArray',
                        'options' => [
                            'haystack' => [
                                'Mysql'   => 'Mysql',
                                'Oracle'  => 'Oracle',
                                'IbmDB2'  => 'IbmDB2',
                                'Sqlite'  => 'Sqlite',
                                'Pgsql'   => 'Pgsql',
                                'Sqlsrv'  => 'Sqlsrv',
                                'Restful' => 'Restful',
                            ],
                        ]
                    ]
                ],
            ]
        );
    }

}