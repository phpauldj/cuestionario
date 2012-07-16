<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suscriptor
 *
 * @author Paul
 */
class App_Controller_Action_Encuestado extends App_Controller_Action{
    
    const MENU_NAME_FICHA = 'ficha';
    const MENU_NAME_CUESTIONARIO = 'cuestionario';
    
    //put your code here
    public function init() {
        parent::init();
        
        //$config = $this->getConfig();
        $this->view->flashMessages = $this->_flashMessenger;
        
        if (!$this->isAuth || empty($this->auth["usuario"])) {
            $this->_redirect("/");
        }
    }
}


