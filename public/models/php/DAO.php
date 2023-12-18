<?php 

require '../../config/Config.php';
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
               $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           }
           catch (PDOException $e)
           {
               echo $e->getMessage();
           }
        }
    }

    /*
        @author Thomas Portelette

        @param $table: the table name

        Selects all the rows from a table

    */

    
    public function selectAllFrom($table)
    {
        $this->init_pdo();
        $query = "SELECT * FROM $table";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /*
        @author Thomas Portelette

        @param $table: the table name
        @param $values: an array of values that are separated by a comma and surrounded by simple quotes

        Inserts a row into a table

    */


    public function insertInto($table, $values)
    {
        $this->init_pdo();
        $query = "INSERT INTO $table VALUES ($values)";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /*
        @author Thomas Portelette

        @param $table: the table name
        @param $values: an array of values that are separated by a comma and surrounded by simple quotes
        @param $condition: the condition that must be met for the row to be updated

        Updates a row from a table

    */

    public function update($table, $values, $condition)
    {
        $this->init_pdo();
        $query = "UPDATE $table SET $values WHERE $condition";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    /*
        @author Thomas Portelette

        @param $table: the table name
        @param $condition: the condition that must be met for the row to be deleted

        Deletes a row from a table
    */

    public function deleteFrom($table, $condition)
    {
        $this->init_pdo();
        $query = "DELETE FROM $table WHERE $condition";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function __destruct()
    {
        $this->pdo = null;
    }



  




}

?>