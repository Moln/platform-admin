<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

/**
 * Class MenuForm
 *
 * @package Admin\Form
 * @author  Moln
 * @version $Id: MenuForm.php 728 2014-09-11 02:55:35Z Moln $
 */
class MenuForm extends Form
{

    public function init()
    {
        $inputFilter = new InputFilter();
        $factory     = new Factory();


        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'    => 'menu_id',
                    'filters' => array(
                        array('name' => 'int')
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'    => 'parent_id',
                    'filters' => array(
                        array('name' => 'int')
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
                        array('name' => 'StringTrim')
                    ),
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'url',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StringTrim')
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'    => 'per_id',
                    'filters' => array(
                        array('name' => 'int')
                    ),
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'order',
                    'required' => false,
                    'filters'  => array(
                        array('name' => 'int')
                    ),
                )
            )
        );

        $this->setInputFilter($inputFilter);
    }
}