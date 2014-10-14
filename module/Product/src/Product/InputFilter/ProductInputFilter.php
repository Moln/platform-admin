<?php

namespace Product\InputFilter;

use Zend\InputFilter\InputFilter;


/**
 * Class ProductInputFilter
 *
 * @package Product\InputFilter
 */
class ProductInputFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(['name' => 'id', 'required' => false]);
        $this->add(['name' => 'name']);
        $this->add(['name' => 'price', 'validators' => [['name' => 'digits']]]);
        $this->add(['name' => 'desc']);
    }
} 