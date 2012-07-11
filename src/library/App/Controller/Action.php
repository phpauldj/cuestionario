<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Action
 *
 * @author Paul
 */
class App_Controller_Action extends Zend_Controller_Action 
{
    //put your code here
    protected $_flashMessenger = null;
    
    public function init() 
    {
        // Auth Storage
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authStorage = Zend_Auth::getInstance()->getStorage()->read();
            $isAuth = true;
        } else {
            $authStorage = null;
            $isAuth = false;
        }

        $this->auth = $authStorage;
        $this->view->assign('auth', $authStorage);
        Zend_Layout::getMvcInstance()->assign('auth', $authStorage);
        Zend_Layout::getMvcInstance()->assign(
            'modulo', $this->getRequest()->getModuleName()
        );
        $config = $this->getConfig();
        Zend_Layout::getMvcInstance()->assign(
            'title', $config->app->title
        );
        
        $this->isAuth = $isAuth;
        $this->view->assign('isAuth', $isAuth);
        Zend_Layout::getMvcInstance()->assign('isAuth', $isAuth);

        defined('MODULE') || define('MODULE', $this->_getParam('module'));
        defined('CONTROLLER') || define('CONTROLLER', $this->_getParam('controller'));
        defined('ACTION') || define('ACTION', $this->_getParam('action'));

        $js = "var modulo_actual='" . MODULE . "';";
        $this->view->headScript()->appendScript($js);

        parent::init();
    }
    
    public function preDispatch() {
        parent::preDispatch();        
        $config = $this->getConfig();

        $this->view->isPost = $this->_request->isPost();
        $this->config = $this->getConfig();
        //$this->log = $this->getLog();
        $this->mediaUrl = $this->config->app->mediaUrl;
        $this->siteUrl = $this->config->app->siteUrl;

        $this->view->assign('mediaUrl', $config->app->mediaUrl);
        $this->view->assign('elementsUrl', $config->app->elementsUrl);
        $this->view->assign('siteUrl', $config->app->siteUrl);
        
        $helper = $this->_helper->getHelper('FlashMessengerCustom');
        $this->_flashMessenger = $helper;
    }
    
    public function postDispatch()
    {
        //parent::postDispatch();        
        $messages = $this->_flashMessenger->getMessages();
        if ($this->_flashMessenger->hasCurrentMessages()) {
            $messages = $this->_flashMessenger->getCurrentMessages();
            $this->_flashMessenger->clearCurrentMessages();
        }
        $this->view->assign('flashMessages', $messages);
        Zend_Layout::getMvcInstance()->assign('flashMessages', $messages);
    }
    
    public function getMessenger()
    {
        return $this->_flashMessenger;
    }
    
    public function getRequest()
    {
        return parent::getRequest();
    }
    
    public function getConfig()
    {
        return Zend_Registry::get('config');
    }
    
    public function getCache()
    {
        return Zend_Registry::get('cache');
    }
    
    public function getAdapter()
    {
        return Zend_Registry::get('db');
    }
    
    public function getLog()
    {
        return Zend_Registry::get('log');
    }
    
    public function getSession()
    {
        $session = new Zend_Session_Namespace('cs');
        return $session;
    }
}


