<?php

require_once __DIR__ . '/../../config/Config.php';
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



    /**
     *   @param $table: the table name
     *
     *   Selects all the rows from a table
     *
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

    /**
     *   @param $table: the table name	
     *   @param $email: the email address we want to check the existence of
     *
     *   Checks if an email address exists in the database, returns true if it does, false if it doesn't
     */

    public function checkIfEmailExists($table, $email)
    {
        $this->init_pdo();
        $query = "SELECT * FROM $table WHERE adresse_email = '$email'";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /** 
     *   @param $table: the table name
     *   @param $email: the email address we want to check the existence of
     *   @param $password: the password we want to check the match of
     *
     *   Checks if a password matches the email address in the database, returns true if it does, false if it doesn't
     *
     */

    public function checkIfPasswordMatches($table, $email, $password)
    {
        $this->init_pdo();
        $query = "SELECT * FROM $table WHERE adresse_email = '$email' AND mot_de_passe = '$password'";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) 
        {
            return true;
        } else 
        {
            return false;
        }
    }

    /**
     *  @param $table: the table name
     *  @param $fields: a string of fields separated by a comma
     *  @param $condition: the condition that must be met for the row to be selected (ex: "id = 1")
     * 
     * 
     */

    public function selectFrom($table, $fields, $condition)
    {
        $this->init_pdo();
        $query = "SELECT ";
        $fieldsQ = "";
        foreach (explode(",", $fields) as $field) 
        {
            $fieldsQ .= "$field,";
        }
        $fieldsQ = substr($fieldsQ, 0, -1);
        $query .= $fieldsQ;
        $query .= " FROM $table WHERE $condition";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /** 
     *   @param $table: the table name
     *   @param $fields: an array of fields 
     *   @param $values: an array of values 
     *
     *   Inserts a row into a table
     *
     */


    public function insertInto($table, $fields, $values)
    {
        $this->init_pdo();

        $query = "INSERT INTO $table (";
        $fieldsQ = "";
        foreach ($fields as $field) 
        {
            $fieldsQ .= "$field,";
        }
        $fieldsQ = substr($fieldsQ, 0, -1);
        $query .= $fieldsQ;
        $query .= ") VALUES (";
        $valuesQ = "";
        foreach ($values as $value) 
        {
            $valuesQ .= "'$value',";
        }
        $valuesQ = substr($valuesQ, 0, -1);
        $query .= $valuesQ;
        $query .= ");";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     *   @param $table: the table name
     *   @param $values: an array of values that are separated by a comma and surrounded by simple quotes
     *   @param $condition: the condition that must be met for the row to be updated
     * 
     *   Updates a row from a table
     *
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


    /** 
     *   @param $table: the table name
     *   @param $condition: the condition that must be met for the row to be deleted
     *
     *   Deletes a row from a table
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

    public function getLastInsertedId()
    {
        $this->init_pdo();
        $query = "SELECT LAST_INSERT_ID()";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['LAST_INSERT_ID()'];
    }

    public function getError()
    {
        $this->init_pdo();
        return $this->pdo->errorInfo();
    }

    public function getPublication($userMail)
    {
        $this->init_pdo();
        $query = "SELECT * FROM publication WHERE adresse_email = '$userMail'";
        $query = "SELECT * FROM publications JOIN utilisateurs ON publications.id_utilisateur = utilisateurs.id_utilisateur WHERE utilisateurs.adresse_email = '$userMail'";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getLinkImages($idPost)
    {
        $this->init_pdo();
        $query = "SELECT photo_url FROM images_publication WHERE id_publication = '$idPost'";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($result)
        {
            return $result[0]['photo_url'];
        }
        else
        {
            return "";
        }
    }
    public function getNbLikes($idPost)
    {
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_likes FROM appreciations WHERE id_publication = :id_post AND type = 'like'";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_post', $idPost, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['nb_likes'];
    }

    public function getNbComments($idPost)
    {
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_comments FROM appreciations WHERE id_publication = :id_post AND commentaire IS NOT NULL";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_post', $idPost, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['nb_comments'];
    }

    public function getNbPublications($id_utilisateur)
    {
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_publications FROM publications GROUP BY id_utilisateur HAVING id_utilisateur = '$id_utilisateur'";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result)
        {
            return $result['nb_publications'];
        }
        else
        {
            return 0;
        }
    }
 

    public function getPaginatedPublications($postsPerPage, $currentPage)
    {
        $this->init_pdo();
        // on calcule le nombre de publications à sauter
        $offset = ($currentPage - 1) * $postsPerPage; 

        $query = "SELECT * FROM publications LIMIT :offset, :limit";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->bindParam(':limit', $postsPerPage, PDO::PARAM_INT);
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