<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Error
 *
 * @author Paul
 */
class App_Controller_Action_Error extends App_Controller_Action {
    //put your code here
    
    public function init() {
        parent::init();
        
        $config = $this->getConfig();
        
        $this->_helper->layout->setLayout('error');
        
        $this->view->headTitle()->set(
            'Ha ocurrido un error - ' . $config->app->title
        );
        
        /*$this->view->headLink()->appendStylesheet(
            $config->app->mediaUrl . '/css/main.admin.css', 'all'
        );*/
    }
}

?>
