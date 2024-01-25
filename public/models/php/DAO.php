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
        if ($this->pdo == null) {
            try {
                $this->pdo = new PDO($this->databaseConnectionString);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
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
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *  @param $table: the table name
     *  @param $fields: a string of fields separated by a comma
     *  @param $condition: the condition that must be met for the row to be selected (ex: "id = 1")
     * 
     *  Selects a row from a table
     */

    public function selectFrom($table, $fields, $condition)
    {
        $this->init_pdo();
        $query = "SELECT ";
        $fieldsQ = "";
        foreach (explode(",", $fields) as $field) {
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
     *  @param $table: the table name
     *  @param $fields: a string of fields separated by a comma
     *  @param $condition: the condition that must be met for the row to be selected (ex: "id = 1")
     * 
     *  Same as selectFrom, but instead we are looking for equivalent for the name or the first name
     */

    public function selectFromEquivalent($table, $input)
    {
        $this->init_pdo();
        $query = "SELECT * FROM $table WHERE nom LIKE '%$input%' OR prenom LIKE '%$input%'";
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
        foreach ($fields as $field) {
            $fieldsQ .= "$field,";
        }
        $fieldsQ = substr($fieldsQ, 0, -1);
        $query .= $fieldsQ;
        $query .= ") VALUES (";
        $valuesQ = "";
        foreach ($values as $value) {
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

    public function executeQuery($query, $params)
    {
        $this->init_pdo();
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
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
        $query = "SELECT * FROM publications JOIN utilisateurs ON publications.id_utilisateur = utilisateurs.id_utilisateur WHERE utilisateurs.adresse_email = '$userMail' ORDER BY date_publication DESC";
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
        if ($result) {
            return $result[0]['photo_url'];
        } else {
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
        return isset($result['nb_likes']) ? $result['nb_likes'] : 0;
    }

    public function getNbDislikes($idPost)
    {
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_dislikes FROM appreciations WHERE id_publication = :id_post AND type = 'dislike'";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_post', $idPost, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        echo "<script>console.log('" . $result['nb_dislikes'] . "')</script>";
        return isset($result['nb_dislikes']) ? $result['nb_dislikes'] : 0;
    }
    public function getAuthorSurname($idPost)
    {
        $this->init_pdo();
        $query = "SELECT nom FROM utilisateurs JOIN publications ON utilisateurs.id_utilisateur = publications.id_utilisateur WHERE publications.id_publication = :id_post";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_post', $idPost, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['nom']) ? $result['nom'] : "";
    }

    public function getAuthorName($idPost)
    {
        $this->init_pdo();
        $query = "SELECT prenom FROM utilisateurs JOIN publications ON utilisateurs.id_utilisateur = publications.id_utilisateur WHERE publications.id_publication = :id_post";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_post', $idPost, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['prenom']) ? $result['prenom'] : "";
    }

    public function getAuthorPhoto($idPost)
    {
        $this->init_pdo();
        $query = "SELECT photo_profil FROM utilisateurs JOIN publications ON utilisateurs.id_utilisateur = publications.id_utilisateur WHERE publications.id_publication = :id_post";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_post', $idPost, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['photo_profil']) ? $result['photo_profil'] : "";
    }

    public function getNbComments($idPost)
    {
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_comments FROM appreciations WHERE id_publication = :id_post AND commentaire IS NOT NULL AND commentaire != '' ";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_post', $idPost, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['nb_comments']) ? $result['nb_comments'] : 0;
    }

    public function getNbPublications($user_mail)
    {
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_publications FROM publications JOIN utilisateurs ON publications.id_utilisateur = utilisateurs.id_utilisateur WHERE utilisateurs.adresse_email = '$user_mail'";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['nb_publications'];
        } else {
            return 0;
        }
    }

    public function getNbTotalPublications()
    {
        // retourne le nb total de publications en enlevant celles bloquées 
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_publications FROM publications WHERE est_bloque = 0";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['nb_publications'];
        } else {
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
        return isset($result) ? $result : array();
    }

    public function getNbFriends($user_mail)
    {
        $this->init_pdo();
        $query = "SELECT COUNT(*) AS nb_friends FROM utilisateurs JOIN amis ON utilisateurs.id_utilisateur = amis.id_utilisateur_demandeur OR utilisateurs.id_utilisateur = amis.id_utilisateur_receveur WHERE utilisateurs.adresse_email = :user_mail AND amis.statut = 'accepte'";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_mail', $user_mail, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['nb_friends'];
        } else {
            return 0;
        }
    }

    public function getFriendsRequest($user_mail)
    {
        $this->init_pdo();
        $query = "SELECT * FROM utilisateurs JOIN amis ON utilisateurs.id_utilisateur = amis.id_utilisateur_demandeur WHERE amis.id_utilisateur_receveur = (SELECT id_utilisateur FROM utilisateurs WHERE adresse_email = :user_mail) AND amis.statut = 'attente'";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_mail', $user_mail, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return isset($result) ? $result : array();
    }

    public function isFriend($myId, $user_id)
    {
        $query = "SELECT * FROM amis WHERE (id_utilisateur_demandeur = :myId AND id_utilisateur_receveur = :user_id) OR (id_utilisateur_demandeur = :user_id AND id_utilisateur_receveur = :myId)";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':myId', $myId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            if ($result[0]['statut'] == "accepte") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function areTheyFriends($mail1, $mail2)
    {
        $this->init_pdo();
        $query = "SELECT * FROM amis WHERE (id_utilisateur_demandeur = (SELECT id_utilisateur FROM utilisateurs WHERE adresse_email = :mail1) AND id_utilisateur_receveur = (SELECT id_utilisateur FROM utilisateurs WHERE adresse_email = :mail2)) OR (id_utilisateur_demandeur = (SELECT id_utilisateur FROM utilisateurs WHERE adresse_email = :mail2) AND id_utilisateur_receveur = (SELECT id_utilisateur FROM utilisateurs WHERE adresse_email = :mail1))";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':mail1', $mail1, PDO::PARAM_STR);
        $statement->bindParam(':mail2', $mail2, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            if ($result[0]['statut'] == "accepte") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function acceptFriendsRequest($myId, $user_id)
    {
        $this->init_pdo();
        $query = "UPDATE amis SET statut = 'accepte' WHERE id_utilisateur_demandeur = :user_id AND id_utilisateur_receveur = :myId";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':myId', $myId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function declineFriendsRequest($myId, $user_id)
    {
        $this->init_pdo();
        $query = "UPDATE amis SET statut = 'refuse' WHERE id_utilisateur_demandeur = :user_id AND id_utilisateur_receveur = :myId";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':myId', $myId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
    }

    public function getIdFromMail($user_mail)
    {
        $this->init_pdo();
        $query = "SELECT id_utilisateur FROM utilisateurs WHERE adresse_email = :user_mail";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_mail', $user_mail, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['id_utilisateur']) ? $result['id_utilisateur'] : 0;
    }

    public function isLiked($user_id, $post_id)
    {
        $this->init_pdo();
        $query = "SELECT * FROM appreciations WHERE id_utilisateur = :user_id AND id_publication = :post_id AND type = 'like'";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isDisliked($user_id, $post_id)
    {
        $this->init_pdo();
        $query = "SELECT * FROM appreciations WHERE id_utilisateur = :user_id AND id_publication = :post_id AND type = 'dislike'";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getPublicationsByTime($dateDebut, $dateFin)
    {
        $this->init_pdo();
        $query = "SELECT * FROM publications WHERE date_publication BETWEEN :dateDebut AND :dateFin";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
        $statement->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return isset($result) ? $result : array();
    }

    public function createNewComment($user_id, $post_id, $comment)
    {
        $this->init_pdo();
        echo "<script>console.log('$user_id')</script>";
        echo "<script>console.log('$post_id')</script>";
        echo "<script>console.log('$comment')</script>";
        $query = "INSERT INTO appreciations (id_utilisateur, id_publication, commentaire) VALUES (:user_id, :post_id, :comment)";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
        $statement->execute();
    }

    public function getComments($post_id)
    {
        $this->init_pdo();
        $query = "SELECT * FROM appreciations JOIN utilisateurs ON appreciations.id_utilisateur = utilisateurs.id_utilisateur WHERE id_publication = :post_id AND commentaire IS NOT NULL";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return isset($result) ? $result : array();
    }

    public function getVisibility($post_id)
    {
        $this->init_pdo();
        $query = "SELECT visibilite FROM publications WHERE id_publication = :post_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['visibilite']) ? $result['visibilite'] : "";
    }

    public function getAuthorEmail($post_id)
    {
        $this->init_pdo();
        $query = "SELECT adresse_email FROM utilisateurs JOIN publications ON utilisateurs.id_utilisateur = publications.id_utilisateur WHERE publications.id_publication = :post_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['adresse_email']) ? $result['adresse_email'] : "";
    }

    public function isBlocked($post_id)
    {
        $this->init_pdo();
        $query = "SELECT est_bloque FROM publications WHERE id_publication = :post_id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['est_bloque']) ? $result['est_bloque'] : 0;
    }

    public function isBlockedUser($user_mail)
    {
        $this->init_pdo();
        $query = "SELECT est_bloque FROM utilisateurs WHERE adresse_email = :user_mail";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_mail', $user_mail, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return isset($result['est_bloque']) ? $result['est_bloque'] : 0;
    }




    /*
        ADMIN
    */

    public function checkIfAdmin($user_id)
    {
        $this->init_pdo();
        $query = "SELECT * FROM administrateurs WHERE id_utilisateur = $user_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUserFromWebsite($user_id)
    {
        $this->init_pdo();
        $query = "DELETE FROM utilisateurs WHERE id_utilisateur = $user_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function deletePostFromWebsite($post_id)
    {
        $this->init_pdo();
        $query = "DELETE FROM publications WHERE id_publication = $post_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function blockPost($post_id)
    {
        $this->init_pdo();
        $query = "UPDATE publications SET est_bloque = 1 WHERE id_publication = $post_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function block_user($user_id)
    {
        $this->init_pdo();
        $query = "UPDATE utilisateurs SET est_bloque = 1 WHERE id_utilisateur = $user_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function unblock_user($user_id)
    {
        $this->init_pdo();
        $query = "UPDATE utilisateurs SET est_bloque = 0 WHERE id_utilisateur = $user_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function doUserExist($user_id)
    {
        $this->init_pdo();
        $query = "SELECT * FROM utilisateurs WHERE id_utilisateur = $user_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function blockContent($publication_id)
    {
        $this->init_pdo();
        $query = "UPDATE publications SET est_bloque = 1 WHERE id_publication = $publication_id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }



    public function __destruct()
    {
        $this->pdo = null;
    }
}

?>