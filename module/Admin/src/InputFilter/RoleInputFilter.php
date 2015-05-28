<?php

namespace Admin\InputFilter;
use Zend\InputFilter\InputFilter;


/**
 * Class RoleInputFilter
 *
 * @package Admin\InputFilter
 * @author  Xiemaomao
 * @version $Id$
 */
class RoleInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            array(
                'name'    => 'menu_id',
                'filters' => array(
                    array('name' => 'int')
                ),
            )
        );

        $this->add(
            array(
                'name'    => 'parent_id',
                'filters' => array(
                    array('name' => 'int')
                ),
            )
        );

        $this->add(
            array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim')
                ),
            )
        );
        $this->add(
            array(
                'name'     => 'url',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim')
                ),
            )
        );

        $this->add(
            array(
                'name'    => 'per_id',
                'filters' => array(
                    array('name' => 'int')
                ),
            )
        );
        $this->add(
            array(
                'name'     => 'order',
                'required' => false,
                'filters'  => array(
                    array('name' => 'int')
                ),
            )
        );
    }
}