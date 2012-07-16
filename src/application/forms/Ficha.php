<?php

/**
 * Description of Form Login
 *
 * @author 
 */
class Application_Form_Ficha extends App_Form
{
    private $_maxArea = '100';
    private $_maxEdad = '2';
    
    public function init()
    {
        parent::init();
        
        // Area ó Especialidad del Negocio
        $e = new Zend_Form_Element_Text('area');
        $e->setRequired();
        $e->setAttrib('maxlength', $this->_maxArea);
        $e->errMsg = "Ingrese Area ó Especialidad de Negocio";
        $this->addElement($e);
        
        // Cargo
        $e = new Zend_Form_Element_Select('cbocargo');
        $e->setRequired();
        $e->addMultiOption('', '.::Seleccione::.');
        $e->addMultiOptions(Application_Model_Cargo::getCargos());
        $e->addMultiOption('O', 'Otro');
        $e->errMsg = "Ingrese Cargo";
        $this->addElement($e);
        
        // Edad
        $e = new Zend_Form_Element_Text('edad');
        $e->setRequired();
        $e->addValidator(new Zend_Validate_Int());
        $e->setAttrib('maxlength', $this->_maxEdad);
        $e->errMsg = "Edad Incorrecta";
        $this->addElement($e);
        
        // Sexo
        $e = new Zend_Form_Element_Radio('sexo');
        $e->setRequired();
        $e->setMultiOptions(array('1'=>'Masculino', '0'=>'Femenino'));
        $e->errMsg = "Ingrese Sexo";
        $this->addElement($e);
        
        // Estado Civil
        $e = new Zend_Form_Element_Select('cboestadocivil');
        $e->setRequired();
        $e->addMultiOption('', '.::Seleccione::.');
        $e->addMultiOptions(Application_Model_EstadoCivil::getEstados());
        $e->errMsg = "Ingrese Estado Civil";
        $this->addElement($e);
        
        // Grado de Instrucción
        $e = new Zend_Form_Element_Select('cbogradoinstruccion');
        $e->setRequired();
        $e->addMultiOption('', '.::Seleccione::.');
        $e->addMultiOptions(Application_Model_GradoInstruccion::getGrados());
        $e->errMsg = "Ingrese Grado de Instrucción";
        $this->addElement($e);
        
        // Tipo de Contratación
        $e = new Zend_Form_Element_Radio('chktipocontrata');
        $e->setRequired();
        $e->setMultiOptions(array('P'=>'Planillas', 'O'=>'Outsourcing'));
        $e->errMsg = "Ingrese Tipo de Contratación";
        $this->addElement($e);
        
//        $e->addValidator(new Zend_Validate_NotEmpty());
//        $v = new Zend_Validate_StringLength(array('min' => 6, 'max' => 15));
//        $e->addValidator($v);
        
        //Submit
        $e = new Zend_Form_Element_Submit('Submit');
        $e->setLabel('Guardar');
        $this->addElement($e);
    }
    
    public function setType($type)
    {
        $e = new Zend_Form_Element_Hidden('tipo');
        $e->setValue($type);
        $this->addElement($e);
        return $this;
    }
    
    public static function factory($type)
    {
        $form = new self();
        return $form->setType($type);
    }
    
}