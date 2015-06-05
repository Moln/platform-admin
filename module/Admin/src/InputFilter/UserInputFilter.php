<?php

namespace Moln\Admin\InputFilter;
use Moln\Admin\Model\UserTable;
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

    public function __construct($edit = true, UserTable $table)
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
        } else {
            $this->add(
                array(
                    'name'       => 'account',
                    'required'   => true,
                    'filters'    => array(
                        array('name' => 'StringTrim'),
                        array('name' => 'StringToLower'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'Db\NoRecordExists',
                            'options' => array(
                                'table'   => $table->getTable(),
                                'field'   => 'account',
                                'adapter' => $table->getAdapter()
                            ),
                        ),
                    ),
                )
            );
        }

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