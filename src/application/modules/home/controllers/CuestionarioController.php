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
class Home_CuestionarioController extends App_Controller_Action_Encuestado{
    
    //put your code here
    public function init() {
        parent::init();
        $this->view->activo = self::MENU_NAME_CUESTIONARIO;
    }
    
    public function indexAction()
    {   
        $preguntaForPage = $this->config->app->elementsForPage;
        $page = ($this->_request->getParam("page", 1));
        
        $p = new Application_Model_Pregunta();
        $listaPregunta = $p->getPregunta(1);
        
        //var_dump($listaPregunta);
        //$paginador = new Zend_Paginator(new Zend_Paginator_Adapter_Array($listaPregunta));
        $paginador = Zend_Paginator::factory($listaPregunta);
        $paginador->setItemCountPerPage($preguntaForPage)->setCurrentPageNumber($page);
        $this->view->listaPreguntas = $paginador;
//        $this->_helper->layout->disableLayout();
//        $this->_helper->viewRenderer->setNoRender();
        
    }
    
     public function preguntasAction()
    {   
        $preguntaForPage = $this->config->app->elementsForPage;
        $page = ($this->_request->getParam("page", 1));
        
        $p = new Application_Model_Pregunta();
        $listaPregunta = $p->getPregunta(1);
        
        //var_dump($listaPregunta);
        //$paginador = new Zend_Paginator(new Zend_Paginator_Adapter_Array($listaPregunta));
        $paginador = Zend_Paginator::factory($listaPregunta);
        $paginador->setItemCountPerPage($preguntaForPage)->setCurrentPageNumber($page);
        $this->view->listaPreguntas = $paginador;
//        $this->_helper->layout->disableLayout();
//        $this->_helper->viewRenderer->setNoRender();
       
//            if ($this->getRequest()->isPost()) {
//                
//                echo "yaaa";
//            $params = $this->_getAllParams();
//            
//            echo "<pre>";
//            print_r($params);
//            echo "</pre>";
//
//        }
    }
    
    public function  agregarAction()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
                  echo "<pre>";
            print_r($params);
            echo "</pre>";
            exit;
//            if ($formAgregar->isValid($params)) {
//                $c->agregarCliente($params);
//                $this->getMessenger()->success('El cliente se agrego con exito!');
//                $this->_redirect('/admin/clientes');
//            }
        }
    }
}

?>
