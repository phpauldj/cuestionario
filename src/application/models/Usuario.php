<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Paul
 */
class Application_Model_Usuario extends App_Db_Table_Abstract
{
    //put your code here
    protected $_name = 'usuario';
    
    public static function auth($login, $pswd, $type, $writeStorage = true)
    {
        $adapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new App_Auth_Adapter_ClubDbTable($adapter);
        $authAdapter->setIdentity($login);
        $authAdapter->setCredential($pswd);
        $authAdapter->setRol($type);
        
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session());
        $authResult = $auth->authenticate($authAdapter);
        $isValid = $authResult->isValid();
        if ($isValid && $writeStorage) {
            $datalogeo = array(); $options = array();
            if ($type == Application_Form_Login::ROL_SUSCRIPTOR ||
                $type == Application_Form_Login::ROL_ADMIN ||
                $type == Application_Form_Login::ROL_ESTABLECIMIENTO ||
                $type == Application_Form_Login::ROL_GESTOR) {

                if ($type == Application_Form_Login::ROL_ADMIN) {
                    $class = "Application_Model_" . ucfirst($type);
                    $model = new $class();
                    $usuario = $authAdapter->getResultRowObject(null, 'pswd');
                    $related = $model->fetchRow('usuario_id = ' . $usuario->id)->toArray();
                    
                    // @codingStandardsIgnoreStart
                    $objop = new Application_Model_OpcionPerfil();
                    $objop->setPerfil_id($usuario->perfil_id);
                    $options = $objop->getOpcionesByPerfil();
                    // @codingStandardsIgnoreEnd
                } elseif ( $type == Application_Form_Login::ROL_ESTABLECIMIENTO ) {
                    $class = "Application_Model_" . ucfirst($type);
                    $model = new $class();
                    $usuario = $authAdapter->getResultRowObject(null, 'pswd');
                    $related = $model->getEstablecimientoPorUsuario($usuario->id);
                    $objAdministrador = new Application_Model_Administrador();
                    $dataS = $objAdministrador
                        ->fetchRow('usuario_id = ' . $usuario->id);
                    
                    if(!empty($dataS)):
                        $datalogeo['datos'] = $dataS->toArray();
                    endif;
                    // @codingStandardsIgnoreStart
                    $objop = new Application_Model_OpcionPerfil();
                    $objop->setPerfil_id($usuario->perfil_id);
                    $options = $objop->getOpcionesByPerfil();
                    // @codingStandardsIgnoreEnd
                    //var_dump($options); exit;
                } else {
                    $class = "Application_Model_" . ucfirst($type);
                    $model = new $class();
//                    $model = new Application_Model_Administrador();
                    $usuario = $authAdapter->getResultRowObject(null, 'pswd');
                    $related = $model->fetchRow('usuario_id = ' . $usuario->id)->toArray();
                    
                    // @codingStandardsIgnoreStart
                    if ($type == Application_Form_Login::ROL_GESTOR) {
                        $objop = new Application_Model_OpcionPerfil();
                        $objop->setPerfil_id($usuario->perfil_id);
                        $options = $objop->getOpcionesByPerfil();
                    }
                    // @codingStandardsIgnoreEnd
                }
            }
            //var_dump($usuario, $options); exit;
            $datalogeo['usuario'] = $usuario;
            $datalogeo[$type] = $related;
            $datalogeo['opciones'] = $options;
            
            $authStorage = $auth->getStorage();
            $authStorage->write(
                $datalogeo
            );
        }
        
        return $isValid;
    }
}
