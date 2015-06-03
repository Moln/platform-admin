<?php

namespace Moln\Admin\InputFilter;
use Zend\InputFilter\InputFilter;


/**
 * Class LoginInputFilter
 * @package Admin\InputFilter
 * @author Xiemaomao
 * @version $Id$
 */
class LoginInputFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(
            array(
                'name'     => 'account',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower'),
                ),
            )
        );

        $this->add(
            array(
                'name'     => 'password',
                'required' => true,
            )
        );
    }
}