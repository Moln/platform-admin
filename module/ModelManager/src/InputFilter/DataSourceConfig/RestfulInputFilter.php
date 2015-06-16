<?php

namespace Moln\ModelManager\InputFilter\DataSourceConfig;
use Zend\InputFilter\InputFilter;


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
    }
}