<?php

class AppPlugin_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    /**
     * Predispatch method to authenticate user
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        //user only to login for access to admin functions
       /* if ('admin' != $request->getModuleName()) {
            return;
        }*/

        if (Application_Model_Users::isLoggedIn() /*&& Application_Model_Users::isAdmin()*/) {
            return;
        }

        if($request->action == 'login')
        {
            $request->setControllerName('auth')
                ->setActionName('login');
        }
    }
}