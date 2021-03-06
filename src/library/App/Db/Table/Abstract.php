<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Abstract
 *
 * @author Paul
 */
class App_Db_Table_Abstract extends Zend_Db_Table_Abstract{
    //put your code here
    protected $_config;
    protected $_prefix;
    protected $_db;
    protected $_log;

    /**
     *
     * @var Zend_Cache
     */
    protected $_cache;

    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->_config = Zend_Registry::get('config');
        //$this->_log = Zend_Registry::get('log');
        $this->_prefix = $this->_name . '_';
        $this->_db = $this->getAdapter();
        //$this->_cache = Zend_Registry::get('cache');
    }
}
?>
