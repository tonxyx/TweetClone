<?php

class AuthController extends Zend_Controller_Action
{
    public function loginAction()
    {
        $db = $this->_getParam('db');

        $loginForm = $this->view->loginForm = new Application_Form_Login();

        $loginData = $this->getRequest()->getParams();

        if($this->getRequest()->isPost())
            if ($loginForm->isValid($loginData)) {

            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'users',
                'email',
                'password',
                //'MD5(?)'
                'MD5(CONCAT(?, password_salt))'
            );

            $adapter->setIdentity($loginForm->getValue('email'));
            $adapter->setCredential($loginForm->getValue('password'));

            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);

            if ($result->isValid()) {
                $user = $adapter->getResultRowObject();
                $auth->getStorage()->write($user);

                // init session cookie
                //$session_auth = new Zend_Session_Namespace('identity');

                $this->redirect('/index/index');
                return true;
            }

        }


    }

    public function signUpAction()
    {
        $signUpForm = $this->view->signUpForm = new Application_Form_SignUp();
        $users = new Application_Model_Users();

        $signUpData = $this->getRequest()->getParams();

        if($this->getRequest()->isPost())
            if ($signUpForm->isValid($signUpData)) {
                if($users->checkUnique($signUpData['email'])){
                    $this->view->errorMessage = "<p>Email address already taken. Please choose another one.</p>";
                    return;
                }

                unset($signUpData['confirmPassword']);
                $users->insertData($signUpData['email'], $signUpData['password']);
                $this->redirect('auth/login');
            }

    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect('/auth/login');
    }

}