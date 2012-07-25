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
class Application_Model_FichaSociodemo extends App_Db_Table_Abstract{
    //put your code here
    protected $_name = 'ficha_sociodemo';
    
    public function getDatosSocioDemoByIdUser($idUsuario)
    {
        $db = $this->getAdapter();
        $sql = $db->select()->from(
            array('fs' => $this->_name ),
            array('*')
        )->where('usuario_id', $idUsuario);
        $rs = $db->fetchRow($sql);
        return $rs;
    }
}

?>
