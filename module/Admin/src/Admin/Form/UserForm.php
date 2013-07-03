<?php
/**
 * platform-admin User.php
 * @DateTime 13-4-15 下午3:49
 */

namespace Admin\Form;

use Admin\Model\UserTable;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * Class User
 * @package Admin\Form
 * @author Moln Xie
 * @version $Id: UserForm.php 1077 2013-07-03 07:47:44Z maomao $
 */
class UserForm extends Form
{
    public function loadInputFilter($edit = false)
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFactory();

        if ($edit) {
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'     => 'user_id',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'int'),
                        ),
                    )
                )
            );
        }

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'account',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StringTrim'),
                        array('name' => 'StringToLower'),
                    ),
                    'validators' => $edit ? array() : array(
                        array(
                            'name'    => 'Db\NoRecordExists',
                            'options' =>     array(
                                'table'   => UserTable::getInstance()->getTable(),
                                'field'   => 'account',
                                'adapter' => UserTable::getInstance()->getAdapter()
                            ),
                        ),
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
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
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'real_name',
                    'required' => true,
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'email',
                    'required' => true,
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'status',
                    'required' => true,
                )
            )
        );
        $this->setInputFilter($inputFilter);
    }
}