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
class Application_Model_Pregunta extends App_Db_Table_Abstract{
    //put your code here
    protected $_name = 'pregunta';
    
    public static function getPregunta($idEncuesta)
    {
        $objest = new Application_Model_Pregunta();
        $db = $objest->getAdapter();
        $sql = $db->select()->from(
            array('p' => $objest->_name ),
            array('id', 'descrip')
        )
        ->where('p.encuesta_id = ?', $idEncuesta);
        $pregunta = $db->fetchAll($sql);
        
        $apregunta = array();
        foreach ($pregunta as $key => $value) {
            $apregunta[$key] = array(
                                    "id"=>$value["id"], 
                                    "descrip"=>$value["descrip"],
                                    "opcion" => $objest->getOpcion($value["id"]) 
                                    );
        }
   
//        echo "<pre>";
//        print_r($apregunta);
//        echo "</pre>";
        
        return $apregunta;
    }
    
    
    public static function getOpcion($idPregunta)
    {
        $objest = new Application_Model_Pregunta();
        $db = $objest->getAdapter();
        $sql = $db->select()->from(
            array('o' => "opcion" ),
            array('id', 'name')
        )   
        ->where('o.pregunta_id = ?', $idPregunta);
        
        
        
//         ->joinLeft(
//                array('r' => "respuesta"),
//                'r.opcion_id= o.id',
//                array('r.opcion_id')
//              )        
        //echo "<br>".$sql."<br>";
        $aopcion = $db->fetchAll($sql);    
        return $aopcion;
    }
}

?>
