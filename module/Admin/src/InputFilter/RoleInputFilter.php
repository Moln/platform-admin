<?php

namespace Moln\Admin\InputFilter;
use Moln\Admin\Model\RoleTable;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Callback;


/**
 * Class RoleInputFilter
 *
 * @package Admin\InputFilter
 * @author  Xiemaomao
 * @version $Id$
 */
class RoleInputFilter extends InputFilter
{
    public function __construct($add, $roles = [], RoleTable $table)
    {

        if (!$add) {
            $this->add(
                array(
                    'name'    => 'role_id',
                    'filters' => array(
                        array('name' => 'int')
                    ),
                )
            );
        }

        $this->add(
            array(
                'name'    => 'parent',
                'filters' => array(
                    array('name' => 'int')
                ),
                'validators' => array(
                    array(
                        'name' => 'callback',
                        'options' => array(
                            'callback' => function ($value) use ($table, $roles) {
                                return $table->isValidParentAtRoles($value, $roles);
                            },
                            'messages' => array(
                                Callback::INVALID_VALUE => '无权设置, 不在人个权限下'
                            ),
                        ),
                    ),
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
    }
}