<?php

require __DIR__ . '/../../models/php/DAO.php';
abstract class Controller
{
    protected $_mainDao;
    protected $_error;
    public function __construct()
    {
        $this->_mainDao = new DAO(Config::DBHOST, Config::DBNAME, Config::DBUSERNAME, Config::DBPASSWORD);
    }

    public function getMainDao()
    {
        return $this->_mainDao;
    }

    public function cleanFormInput()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value);
            $_POST[$key] = trim($value);
            $_POST[$key] = stripslashes($value);
        }
    }

    public function getError()
    {
        return $this->_error;
    }


}

?>