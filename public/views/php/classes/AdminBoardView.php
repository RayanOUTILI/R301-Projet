<?php

class AdminBoardView extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../admin_board.php");
    }

    public function renderUserSearch($users)
    {
        $this->render();
        foreach($users as $user)
        {
            echo "<div class='user'>";
            echo "<p>Nom : " . $user['nom'] . "</p>";
            echo "<p>Prénom : " . $user['prenom'] . "</p>";
            echo "<p>Date de naissance : " . $user['date_naissance'] . "</p>";
            echo "<p>Adresse : " . $user['adresse'] . "</p>";
            echo "<p>Téléphone portable : " . $user['telephone_portable'] . "</p>";
            echo "<p>Adresse email de secours : " . $user['adresse_email_secours'] . "</p>";
        }
        require __DIR__ . "/../indexfooter.php";

    }

    public function renderNoUserFound()
    {
        $this->render();
        echo "<p>Aucun utilisateur trouvé</p>";
        require __DIR__ . "/../indexfooter.php";
    }
}

?>