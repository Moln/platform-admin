<?php

namespace Moln\Admin\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Callback;


/**
 * Class SelfInputFilter
 *
 * @package Admin\InputFilter
 * @author  Xiemaomao
 * @version $Id$
 */
class SelfInputFilter extends InputFilter
{
    public function __construct()
    {

        $this->add(
            array(
                'name'       => 'password',
                'required'   => false,
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
                'name'       => 'confirm_password',
                'required'   => false,
                'validators' => array(
                    array(
                        'name'     => 'Callback',
                        'options'  => array(
                            'callback' => function ($value, $row) {
                                return $row['password'] == $value;
                            }
                        ),
                        'messages' => array(
                            Callback::INVALID_VALUE => '两次输入的密码不一致'
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
                'name'       => 'email',
                'required'   => true,
                'validators' => array(
                    array('name' => 'EmailAddress'),
                ),
            )
        );
    }

}