<?php
require_once __DIR__ . '/../../config/Config.php';

$erreur = false;
$messageErreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $adr_mail = $_POST['adr_mail'];


    $host = "linserv-info-01.campus.unice.fr";
    $db_name = "or201305_R301-Projet";
    $username = "or201305";
    $password = "s]3zY[KhQ54(*qC0";
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie";
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    try {
        $stmt = $bdd->prepare("INSERT INTO personne (nom, prenom, age, adr_mail) VALUES (:nom, :prenom, :age, :adr_mail)");
        $stmt->bindParam(":adr_mail", $adr_mail);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":age", $age);
        $stmt->execute();

        echo "L'utilisateur a été créé avec succès !";

        header("Location: connexion.php");
        exit();
    } catch (PDOException $e) {
        $erreur = true;
        $messageErreur = "Erreur : " . $e->getMessage();
    }
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
