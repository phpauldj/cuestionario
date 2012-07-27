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
        
        $paginador = Zend_Paginator::factory($listaPregunta);
        $paginador->setItemCountPerPage($preguntaForPage)->setCurrentPageNumber($page);
        $this->view->listaPreguntas = $paginador;
        
        $this->render('preguntas');
    }
    
     public function preguntasAction()
    {
        $preguntaForPage = $this->config->app->elementsForPage;
        $page = ($this->_request->getParam("page", 1));
        
        $p = new Application_Model_Pregunta();
        $listaPregunta = $p->getPregunta(1);
        
        $paginador = Zend_Paginator::factory($listaPregunta);
        $paginador->setItemCountPerPage($preguntaForPage)->setCurrentPageNumber($page);
        $this->view->listaPreguntas = $paginador;
    }
    
    public function  agregarAction()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            $page = ($this->_request->getParam("page", 1));
            
            unset($params['button']);
            unset($params['action']);
            unset($params['controller']);
            unset($params['module']);
            unset($params['page']);
            
            $p = new Application_Model_Pregunta();
           
             foreach ($params as $key => $value) {
                 $op = $p->getRespuesta($key);
                 
                 if (empty($op)){
                     $data['opcion_id'] = $value;
                     $data['pregunta_id'] = $key;
                     $p->addOpcion($data, $this->auth['usuario']->id);
                 } else {
                      $data['opcion_id'] = $value;
                      $p->updateOpcion($data, $key, $this->auth['usuario']->id);
                 }
            }
            $this->_redirect('/cuestionario/index/page/'.$page);

        }
    }
}

?>
