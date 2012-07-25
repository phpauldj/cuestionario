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
        $opera = 'new';
//        $this->_helper->layout->disableLayout();
//        $this->_helper->viewRenderer->setNoRender();
        $frmficha = new Application_Form_Ficha();
        $objficha = new Application_Model_FichaSociodemo();
        $idUsuario = $this->auth['usuario']->id;
        
        if ($this->_request->isPost()) {
            
            $values = $this->getRequest()->getParams();
            $opera = $values['opera'];
            if ($values['area']=='O')
                $frmficha->setRequiredTextArea();
            if ($values['cbocargo']=='O')
                $frmficha->setRequiredTextCargo();
            if ($values['cbogradoinstruccion']=='5')
                $frmficha->setRequiredTextGradoI();
            
            if ($frmficha->isValid($values)) {
                $db = $this->getAdapter();
                $data = array();
                try {
                    $db->beginTransaction();
                    $data['edad'] = $values['edad'];
                    $data['sexo'] = $values['sexo'];
                    $data['especialidad_id'] = $values['area'];
                    $data['grado_instruccion_id'] = $values['cbogradoinstruccion'];
                    $data['cargo_id'] = $values['cbocargo'];
                    $data['estado_civil_id'] = $values['cboestadocivil'];
                    $data['tipo_contrata'] = $values['tipocontrata'];
                    if ($values['area']=='O') {
                        $objarea = new Application_Model_Especialidad();
                        $ida = $objarea->insert(
                            array('name'=>$values['txtarea'])
                        );
                        $data['especialidad_id'] = $ida;
                    }
                    if ($values['cbocargo']=='O') {
                        $objcargo = new Application_Model_Cargo();
                        $idc = $objcargo->insert(
                            array('name'=>$values['txtcargo'])
                        );
                        $data['cargo_id'] = $idc;
                    }
                    if ($values['cbogradoinstruccion']=='5') {
                        $objgrado = new Application_Model_GradoInstruccion();
                        $idg = $objgrado->insert(
                            array('name'=>$values['txtgradoi'])
                        );
                        $data['grado_instruccion_id'] = $idg;
                    }
                    
                    if ($opera=='new') {
                        $data['usuario_id'] = $idUsuario;
                        $objficha->insert($data);
                    } elseif($opera=='edit') {
                        $where = $objficha->getAdapter()
                            ->quoteInto('usuario_id = ?', $idUsuario);
                        $objficha->update($data, $where);
                    }
                    
                    $db->commit();
                    $this->getMessenger()->success('Datos Grabados Exitosamente');
                } catch (Exception $exc) {
                    $this->getMessenger()->error('Ocurrio un Error en el Proceso');
                    $db->rollBack();
                    //echo $exc->getTraceAsString();
                }
            }
            $frmficha->setDefaults($values);
        } else {
            //var_dump($this->auth['usuario']->id);
            $dataficha = $objficha->getDatosSocioDemoByIdUser($idUsuario);

            if (!empty($dataficha)) {
                $opera = 'edit';
                $frmficha->setArea($dataficha['especialidad_id']);
                $frmficha->setCargo($dataficha['cargo_id']);
                $frmficha->setEdad($dataficha['edad']);
                $frmficha->setSexo($dataficha['sexo']);
                $frmficha->setEstadoCivil($dataficha['estado_civil_id']);
                $frmficha->setGradoInstruccion($dataficha['grado_instruccion_id']);
                $frmficha->setTipoContratacion($dataficha['tipo_contrata']);
            }
        }
        $this->view->frmficha = $frmficha;
        $this->view->opera = $opera;
    }
}

?>
