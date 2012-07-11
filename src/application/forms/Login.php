<?php

/**
 * Description of Form Login
 *
 * @author 
 */
class Application_Form_Login extends App_Form
{
    const ROL_USUARIO = 'usuario';
    const ROL_ADMIN = 'admin'; // creador
    
    public function init()
    {
        parent::init();
        
        // Email
        $e = new Zend_Form_Element_Text('userEmail');
        $e->setRequired();
        $e->addValidator(new Zend_Validate_EmailAddress(), true);
        $e->addValidator(new Zend_Validate_NotEmpty(), true);
        $e->errMsg = "No parece ser un correo electrónico valido";
        //$e->setValue('Ingresa tu e-mail');
        $this->addElement($e);
        
        // Clave
        $e = new Zend_Form_Element_Password('userPass');
        $e->setRequired();
        $e->addValidator(new Zend_Validate_NotEmpty());
        $v = new Zend_Validate_StringLength(array('min' => 6, 'max' => 15));
        $e->addValidator($v);
        //$e->setValue('Ingresa tu contraseña');
        $e->errMsg = '¡Usa de 6 a 15 caracteres!';
        $this->addElement($e);
        
        //Checkbox save Session
        /*$e = new Zend_Form_Element_Checkbox('save');
        $e->setValue(false);
        $this->addElement($e);*/
        
        // CSFR protection
        $e = new Zend_Form_Element_Hash('auth_token');
        $e->setRequired(false);
        $this->addElement($e);
        
        $e = new Zend_Form_Element_Hidden('return');
        $return = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        if ($return == '/admin' || $return == '/admin/') {
            $return = str_replace('/', '', $return);
            $return = '/'.$return;
        }
        if ($return == '/') {
            $return .= 'inicio';
        }
        
        $e->setValue($return);
        $e->clearDecorators();
        $e->addDecorator('ViewHelper');
        $this->addElement($e);
        
        //Submit
        $e = new Zend_Form_Element_Submit('Submit');
        $e->setLabel('');
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