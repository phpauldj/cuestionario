<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InicioController
 *
 * @author Paul
 */
class Home_PanelController extends App_Controller_Action_Encuestado{
    
    //put your code here
    public function init() {
        parent::init();
        $this->view->activo = self::MENU_NAME_FICHA;
    }
    
    public function indexAction()
    {
//        $this->_helper->layout->disableLayout();
//        $this->_helper->viewRenderer->setNoRender();
        $frmficha = new Application_Form_Ficha();
        
        if ($this->_request->isPost()) {
            
            $values = $this->getRequest()->getParams();
            if ($frmficha->isValid($values)) {
                
            }
            $frmficha->setDefaults($values);
        }
        $this->view->frmficha = $frmficha;
    }
}

?>
