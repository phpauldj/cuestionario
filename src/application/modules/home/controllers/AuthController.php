<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author Paul
 */
class Home_AuthController extends App_Controller_Action {
    //put your code here
    
    protected $_messageSuccess = 'Bienvenido';
    protected $_messageError = 'Error al iniciar sesión';
    
    public function loginAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        //echo 'aaa'; exit;
        var_dump($this->getRequest()->isPost()); exit;
        if ($this->isAuth) {
            $moduloLogin = $this->auth["usuario"]->rol;
            $modulo = $this->_getParam("tipo");
            if ($modulo != $moduloLogin) {
                Zend_Auth::getInstance()->clearIdentity();
            } else {
                $this->_redirect($this->_request->getPost('return') . '/');
            }
        }
        $rutaQueEnvio = $this->getRequest()->getServer('HTTP_REFERER');
        $next = $this->getRequest()->getParam('next', $rutaQueEnvio);
        
        if ($this->getRequest()->isPost()) {
            Zend_Auth::getInstance()->clearIdentity();
            $login = $this->getRequest()->getPost('userEmail', '');
            $pswd = $this->getRequest()->getPost('userPass', '');
            $type = $this->getRequest()->getPost('tipo', '');
            $isValid = Application_Model_Usuario::auth($login, $pswd, $type);

            if ($this->getRequest()->getPost('save', '') == '1') {
                $config = $this->getConfig();
                Zend_Session::rememberMe($config->app->sessionRemember);
            }
            
            if ($isValid) {
                # TODO : Cambiar dirección de inicio
                $this->getMessenger()->success($this->_messageSuccess);
            } else {
                $this->getMessenger()->error(
                    $this->_messageError . ': Datos inválidos'
                );
            }
        }
        if ($next == $this->config->app->siteUrl . '/') {
            $next = '/mi-cuenta';
        }
        $this->_redirect($next);
    }
    
    public function logoutAction()
    {
        $next = $this->getRequest()->getParam('next', $this->view->baseUrl('/'));
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect($next);
    }
}