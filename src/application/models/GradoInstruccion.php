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
class Application_Model_GradoInstruccion extends App_Db_Table_Abstract{
    //put your code here
    protected $_name = 'grado_instruccion';
    
    public static function getGrados()
    {
        $objgra = new Application_Model_GradoInstruccion();
        $db = $objgra->getAdapter();
        $sql = $db->select()->from(
            array('ec' => $objgra->_name ),
            array('id', 'name')
        );
        $rs = $db->fetchPairs($sql);
        return $rs;
    }
}

?>
