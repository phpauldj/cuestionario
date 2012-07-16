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
class Application_Model_Cargo extends App_Db_Table_Abstract{
    //put your code here
    protected $_name = 'cargo';
    
    public static function getCargos()
    {
        $objcar = new Application_Model_Cargo();
        $db = $objcar->getAdapter();
        $sql = $db->select()->from(
            array('c' => $objcar->_name ),
            array('id', 'name')
        );
        $rs = $db->fetchPairs($sql);
        return !empty($rs)?$rs:array();
    }
}

?>
