<?php

require "../../controllers/php/MainController.php";

$controller = new MainController();

$erreur = false;
$messageErreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $adr_mail = $_POST['adr_mail'];

    $controller->getMainDao()->insertInto("utilisateurs", "'$nom', '$prenom', '$adr_mail', '$age'");

    $controller->getMainDao()->selectAllFrom("utilisateurs");

    
  


    

  
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>

        <?php
        if ($erreur) {
            echo "<div class='erreur'>$messageErreur</div>";
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="nom" placeholder="Nom" required><br>
            <input type="text" name="prenom" placeholder="Prénom" required><br>
            <input type="email" name="adr_mail" placeholder="Adresse e-mail" required><br>
            <input type="number" name="age" placeholder="Âge" required><br>
            <input type="submit" value="S'inscrire">
        </form>
        <p><a class="button-link" href="connexion.php">Déjà inscrit ? Connectez-vous</a></p>
    </div>
</body>
</html>
