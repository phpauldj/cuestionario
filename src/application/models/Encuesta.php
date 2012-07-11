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
class Application_Model_Encuesta extends App_Db_Table_Abstract{
    //put your code here
    protected $_name = 'encuesta';
    
//    public function validNoExists($email = '')
//    {
//        $db = $this->getAdapter();
//        $sql = $db->select()->from(
//            array('s' => $this->_name ),
//            array('email')
//        )
//        ->where('email = ?', $email);
//        $rs = $db->fetchRow($sql);
//        return empty($rs);
//    }
}

?>
