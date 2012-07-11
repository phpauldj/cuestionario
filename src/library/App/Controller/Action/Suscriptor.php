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
class App_Controller_Action_Suscriptor extends App_Controller_Action{
    //put your code here
    public function init() {
        parent::init();
        
        //$config = $this->getConfig();
        
        $this->view->flashMessages = $this->_flashMessenger;
    }
}


