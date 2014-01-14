<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initApplicationAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Application',
            'basePath' => dirname(__FILE__),
        ));
        return $autoloader;
    }

    /**
     *
     * Register plugins
     */
    protected function _initRegisterPlugins()
    {
        $this->bootstrap('Frontcontroller')
            ->getResource('Frontcontroller')
            ->registerPlugin(new AppPlugin_Controller_Plugin_Auth());
    }

    /**
     * (non-PHPdoc)
     * @see Application/Bootstrap/Zend_Application_Bootstrap_Bootstrap::run()
     */
    public function run()
    {
        Zend_Registry::set('config', new Zend_Config($this->getOptions()));

        //start the sessions
        Zend_Session::start();

        parent::run();
    }
}
