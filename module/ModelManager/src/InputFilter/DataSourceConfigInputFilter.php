<?php

namespace Moln\ModelManager\InputFilter;

use Zend\InputFilter\InputFilter;


/**
 * Class DatabaseConfigInputFilter
 *
 * @package Moln\ModelManager\InputFilter
 * @author  Xiemaomao
 * @version $Id$
 */
class DataSourceConfigInputFilter extends InputFilter
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
        $this->add(
            [
                'name'    => 'hostname',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
        $this->add(
            [
                'name'    => 'username',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
        $this->add(
            [
                'required' => false,
                'name'    => 'password',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
        $this->add(
            [
                'required' => false,
                'name'    => 'port',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
        $this->add(
            [
                'name'    => 'database',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
        $this->add(
            [
                'required' => false,
                'name'    => 'charset',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
    }

}