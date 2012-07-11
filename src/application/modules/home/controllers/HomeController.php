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
        if ($this->isAuth && isset($this->auth["admin"])) {
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
                //$this->_redirect('/auth/login');
                $frmlogin->setAction('/auth/login');
                
            } else {
                echo 'aa';
            }
            $frmlogin->setDefaults($values);
        }
        
        $this->view->frmlogin = $frmlogin;
    }
}

