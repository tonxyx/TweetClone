<?php

class Application_Form_SignUp extends Zend_Form
{
    public function init()
    {
        $email = $this->createElement('text','email');
        $email->setLabel('Email: *')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addValidator(new Zend_Validate_EmailAddress());

        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
            ->setRequired(true);

        $confirmPassword = $this->createElement('password','confirmPassword');
        $confirmPassword->setLabel('Confirm Password: *')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_Identical('password'))
            ->addErrorMessage('Invalid password!');

        $signUp = $this->createElement('submit','signUp');
        $signUp->setLabel('Sign Up')
            ->setIgnore(true);

        $this->addElements(array(
            $email,
            $password,
            $confirmPassword,
            $signUp
        ));
    }
}