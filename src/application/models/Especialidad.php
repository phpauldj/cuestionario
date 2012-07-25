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
class Application_Model_Especialidad extends App_Db_Table_Abstract{
    //put your code here
    protected $_name = 'especialidad';
    
    public static function getEspecialidades()
    {
        $objesp = new Application_Model_Especialidad();
        $db = $objesp->getAdapter();
        $sql = $db->select()->from(
            array('c' => $objesp->_name ),
            array('id', 'name')
        );
        $rs = $db->fetchPairs($sql);
        return !empty($rs)?$rs:array();
    }
}

?>
