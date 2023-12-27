<?php

require __DIR__ . '/../../models/php/DAO.php';
abstract class Controller
{
    protected $_model;
    protected $_mainDao;
    public function __construct()
    {
        $this->_mainDao = new DAO(Config::DBHOST, Config::DBNAME, Config::DBUSERNAME, Config::DBPASSWORD);
    }

    public function getMainDao()
    {
        return $this->_mainDao;
    }

    public function getModel()
    {
        return $this->_model;
    }

    
}

?>