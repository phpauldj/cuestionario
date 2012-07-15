<?php

class Home_HomeController extends App_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        parent::init();
    }

    public function indexAction()
    {
        if ($this->isAuth && isset($this->auth["usuario"])) {
            $this->_redirect("/inicio");
        }
        //var_dump($this->_getAllParams());
        $this->view->headTitle('Ingreso');
        
        $frmlogin = new Application_Form_Login();
        $frmlogin->setType(Application_Form_Login::ROL_USUARIO);
        
        if ($this->_request->isPost()) {
            $values = $this->_getAllParams(); //$frmlogin->getValues();
            $valid = $frmlogin->isValid($values);
            //var_dump($values, $valid); //exit;
            if ($valid) {
                $data = $frmlogin->getValues();
                $data['method'] = 'post';
                //var_dump($data); exit;
                //$this->_redirect('/auth/login', $data);
                $this->loginAction($data);
            }
            $frmlogin->setDefaults($values);
        }
        
        $this->view->frmlogin = $frmlogin;
    }
    
    protected $_messageSuccess = 'Bienvenido';
    protected $_messageError = 'Error al iniciar sesión';
    
    public function loginAction($data)
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        //echo 'aaa'; exit;
        //var_dump($data, $this->getRequest()->isPost()); exit;
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
                $next = '/inicio';
                $this->getMessenger()->success($this->_messageSuccess);
            } else {
                $next = '/';
                $this->getMessenger()->error(
                    $this->_messageError . ': Datos inválidos'
                );
            }
        }
//        if ($next == $this->config->app->siteUrl . '/') {
//            $next = '/inicio';
//        }
        $this->_redirect($next);
    }
    
    public function logoutAction()
    {
        $next = $this->getRequest()->getParam('next', $this->view->baseUrl('/'));
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect($next);
    }
}

