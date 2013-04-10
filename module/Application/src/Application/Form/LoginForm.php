<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * LoginForm
 * @author Administrator
 * @DateTime 12-12-29 下午2:37
 * @version $Id$
 */
class LoginForm extends Form
{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->add(
            array(
                'name'       => 'login',
                'attributes' => array(
                    'type' => 'text',
                ),
            )
        );
        $this->add(
            array(
                'name'       => 'password',
                'attributes' => array(
                    'type' => 'password',
                ),
            )
        );
    }

    public function loadInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFactory();
        $inputFilter->add($factory->createInput(array(
            'name'     => 'account',
            'required' => true,
            'filters'  => array(
                array('name' => 'StringTrim'),
                array('name' => 'StringToLower'),
            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name'     => 'password',
            'required' => true,
        )));
        $this->setInputFilter($inputFilter);
    }
}