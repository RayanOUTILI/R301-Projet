<?php 

class DAO
{
    protected $dbHost = "";
    protected $dbName = "";
    protected $dbUsername = "";
    protected $dbPassword = "";
    protected $databaseConnectionString = "";
    private $pdo = null;

    public function __construct($dbHost, $dbName, $dbUsername, $dbPassword)
    {
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->databaseConnectionString = "mysql:host=$this->dbHost;dbname=$this->dbName;user=$this->dbUsername;password=$this->dbPassword;charset=utf8";
    }

    private function init_pdo()
    {
        if ($this->pdo == null)
        {
           try
           {
               $this->pdo = new PDO($this->databaseConnectionString);
           }
           catch (PDOException $e)
           {
               echo $e->getMessage();
           }
        }
    }

    /*
        Doc about how we will use all the following methods:

        @param $table: the table name
        @param $values: an array of values that are separated by a comma



    */




    public function insertInto($table, $values)
    {

    }

    public function __destruct()
    {
        $this->pdo = null;
    }



  




}

?>