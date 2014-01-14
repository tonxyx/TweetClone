<?php

class Application_Form_Login extends Zend_Form
{
    public function init(){

        parent::init();         //koristi parrent::init() kad extendamo zend funkcije, ali i svoje

        $this->setMethod('post');

        $this->addElement(
            'text', 'email', array(
            'label' => 'Email:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));

        $this->addElement(
            'password', 'password', array(
            'label' => 'Password:',
            'required' => true,
        ));

        $this->addElement(
            'submit', 'submit', array(
            'ignore' => true,
            'label' => 'Login',
        ));

    }
}