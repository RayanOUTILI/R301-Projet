<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./public/views/js/form.js"></script>
    <link rel="stylesheet" href="./public/views/css/form.css">
    <title>Connexion</title>
</head>

<?php

// require "../../controllers/php/MainController.php";

// $controller = new MainController();

// $erreur = false;
// $messageErreur = "";

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $nom = $_POST['nom'];
//     $prenom = $_POST['prenom'];
//     $adresse_email = $_POST['adresse_email'];
//     $email_secours = $_POST['email_secours'];
//     $mot_de_passe = $_POST['mot_de_passe'];
//     $adresse = $_POST['adresse'];
//     $telephone_portable = $_POST['telephone_portable'];
//     $date_naissance = $_POST['date_naissance'];
//     $photo_profil = $_POST['photo_profil'];

//     $controller->getMainDao()->insertInto("utilisateurs", "'$nom', '$prenom', '$adresse_email', '$email_secours', '$mot_de_passe', '$adresse', '$telephone_portable', '$date_naissance', '$photo_profil'");

//     $controller->getMainDao()->selectAllFrom("utilisateurs");

// }

?>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="/public/controllers/php/Login.php" method="POST">
                <input type="text" placeholder="Nom" name="nom" />
                <input type="text" placeholder="Prénom" name="prenom" />
                <input type="email" placeholder="Mail" name="adresse_email" />
                <input type="email" placeholder="Mail de récupération" name="email_secours" />
                <input type="password" placeholder="Mot de passe" name="mot_de_passe" />
                <input type="text" placeholder="Adresse" name="adresse" />
                <input type="text" placeholder="Téléphone portable" name="telephone_portable" />
                <input type="date" placeholder="Date de naissance" name="date_naissance" />
                <input type="file" accept="image/*" placeholder="Photo de profil" name="photo_profil" />
                <button type="submit">S'inscrire</button>
            </form>

        </div>
        <div class="form-container sign-in-container">
            <form action="#">
                <h1>Se connecter</h1>
                <span>Entrer vos informations</span>
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Password" />
                <a href="#">Mot de passe oublié ?</a>
                <button>Se connecter</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <button class="ghost" id="signIn">Connexion</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Pas encore inscrit ?</h1>
                    <p>Commencez dès maintenant !</p>
                    <button class="ghost" id="signUp">S'inscire</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>