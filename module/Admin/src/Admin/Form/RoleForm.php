<?php
namespace Admin\Form;

use Admin\Model\RoleTable;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * Class RoleForm
 *
 * @package Admin\Form
 * @author  Moln Xie
 */
class RoleForm extends Form
{

    /**
     * @var AbstractTableGateway
     */
    private $table;

    public function loadInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFactory();

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'role_id',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'int'),
                    ),
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'       => 'name',
                    'required'   => true,
                    'filters'    => array(
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'Db\NoRecordExists',
                            'options' => array(
                                'table'   => $this->get('RoleTable')->getTable(),
                                'field'   => 'name',
                                'adapter' => $this->get('RoleTable')->getAdapter()
                            ),
                        ),
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'parent',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'int'),
                    ),
                )
            )
        );

        $this->setInputFilter($inputFilter);
    }
}