<?php
/**
 * platform-admin User.php
 * @DateTime 13-4-15 下午3:49
 */

namespace System\Form;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * Class User
 * @package System\Form
 * @author Xiemaomao
 * @version $Id$
 */
class UserForm extends Form
{

    /**
     * @var AbstractTableGateway
     */
    private $table;

    public function setTableGateway(AbstractTableGateway $table)
    {
        $this->table = $table;
        return $this;
    }

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
                                'table'   => $this->table->getTable(),
                                'field'   => 'account',
                                'adapter' => $this->table->getAdapter()
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