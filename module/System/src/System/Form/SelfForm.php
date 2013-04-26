<?php
/**
 * platform-admin SelfForm.php
 * @DateTime 13-4-26 下午2:59
 */

namespace System\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class SelfForm
 * @package System\Form
 * @author Xiemaomao
 * @version $Id$
 */
class SelfForm extends Form
{
    public function loadInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFactory();

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'       => 'password',
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
                    'name'       => 'confirm_password',
                    'validators' => array(
                        array(
                            'name'    => 'Callback',
                            'options' => function ($value, $row) {
                                var_dump(func_get_args());exit;
                                return true;
                            },
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
                    'validators' => array(
                        array('name' => 'EmailAddress'),
                    ),
                )
            )
        );
        $this->setInputFilter($inputFilter);
    }
}