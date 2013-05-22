<?php
/**
 * platform-admin RoleForm.php
 * @DateTime 13-4-18 上午10:12
 */

namespace Admin\Form;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * Class RoleForm
 * @package Admin\Form
 * @author Moln Xie
 * @version $Id$
 */
class RoleForm extends Form
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
                    'name'     => 'name',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'Db\NoRecordExists',
                            'options' =>     array(
                                'table'   => $this->table->getTable(),
                                'field'   => 'name',
                                'adapter' => $this->table->getAdapter()
                            ),
                        ),
                    ),
                )
            )
        );

        $this->setInputFilter($inputFilter);
    }
}