<?php

namespace Moln\ModelManager\InputFilter\DataSourceConfig;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\ArrayInput;


/**
 * Class RestfulInputFilter
 * @package Moln\ModelManager\InputFilter\DataSourceConfig
 * @author Xiemaomao
 * @version $Id$
 */
class RestfulInputFilter extends InputFilter
{

    public function __construct()
    {

        $this->add(
            [
                'name'    => 'url',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
        $this->add(
            [
                'type'    => 'Zend\InputFilter\ArrayInput',
                'name'    => 'fields',
                'filters' => [
                    ['name' => 'StringTrim']
                ],
            ]
        );
    }
}