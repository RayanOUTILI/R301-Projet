<?php

abstract class MainController
{
    protected $_model;
    protected $_mainDao;
    public function __construct()
    {
        $this->_mainDao = new DAO(Config::DBHOST, Config::DBNAME, Config::DBUSERNAME, Config::DBPASSWORD);
    }
    
}

?>