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
class Application_Model_EstadoCivil extends App_Db_Table_Abstract{
    //put your code here
    protected $_name = 'estado_civil';
    
    public static function getEstados()
    {
        $objest = new Application_Model_EstadoCivil();
        $db = $objest->getAdapter();
        $sql = $db->select()->from(
            array('ec' => $objest->_name ),
            array('id', 'name')
        );
        $rs = $db->fetchPairs($sql);
        return $rs;
    }
}

?>
