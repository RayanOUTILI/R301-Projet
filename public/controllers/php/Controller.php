<?php

require './public/models/php/DAO.php';
abstract class Controller
{
    protected $_model;
    protected $_mainDao;
    public function __construct()
    {
        $this->_mainDao = new DAO(Config::DBHOST, Config::DBNAME, Config::DBUSERNAME, Config::DBPASSWORD);
        $insertion = $this->_mainDao->insertInto("utilisateurs", "'Portelette','Thomas','thomas.portelette@etu.unice.fr','19'");
        $result = $this->_mainDao->selectAllFrom("utilisateurs");
        $deletion = $this->_mainDao->deleteFrom("utilisateurs", "nom='Portelette'");
        //echo all the array

        foreach($result as $row)
        {
            echo $row['nom'] . " "; 
            echo $row['prenom'] . " ";
            echo $row['mail'] . " ";
            echo $row['age'] . " ";
            echo "<br>";
        }


        



    }
    
}

?>