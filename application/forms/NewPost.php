<?php

class Application_Form_NewPost extends Zend_Form
{

    public function init()
    {
        parent::init();

       $this->setMethod('post');

       /*$this->addElement(
           'text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));*/

        $this->addElement(
            'textarea', 'postText', array(
            'label'      => 'Your post:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(5, 255))
            )
        ));

        $this->addElement(
            'submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Post it out!',
        ));
    }


}

