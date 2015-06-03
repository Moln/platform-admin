<?php

namespace Moln\Admin\InputFilter;
use Zend\InputFilter\InputFilter;


/**
 * Class UserInputFilter
 *
 * @package Admin\InputFilter
 * @author  Xiemaomao
 * @version $Id$
 */
class UserInputFilter extends InputFilter
{

    public function __construct($edit = true)
    {

        if ($edit) {
            $this->add(
                array(
                    'name'     => 'user_id',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'int'),
                    ),
                )
            );
        }

        $this->add(
            array(
                'name'       => 'account',
                'required'   => true,
                'filters'    => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower'),
                ),
                'validators' => $edit ? array() : array(
                    array(
                        'name'    => 'Db\NoRecordExists',
                        'options' => array(
                            'table'   => $this->get('UserTable')->getTable(),
                            'field'   => 'account',
                            'adapter' => $this->get('UserTable')->getAdapter()
                        ),
                    ),
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'password',
                'required'   => !$edit,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                            'max' => 16
                        ),
                    ),
                ),
            )
        );
        $this->add(
            array(
                'name'     => 'real_name',
                'required' => true,
            )
        );
        $this->add(
            array(
                'name'     => 'email',
                'required' => true,
            )
        );
        $this->add(
            array(
                'name'     => 'status',
                'required' => true,
            )
        );
    }
}