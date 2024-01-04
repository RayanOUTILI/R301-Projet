<?php
require __DIR__ . "/headers/formheader.php";
?>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="POST" action="index.php?action=signup">
                <input type="text" placeholder="Nom" name="nom" />
                <input type="text" placeholder="Prénom" name="prenom" />
                <input type="email" placeholder="Mail" name="adresse_email" />
                <input type="email" placeholder="Mail de récupération" name="email_secours" />
                <input type="password" placeholder="Mot de passe" name="mot_de_passe" />
                <input type="text" placeholder="Adresse" name="adresse" />
                <input type="text" placeholder="Téléphone portable" name="telephone_portable" />
                <input type="date" placeholder="Date de naissance" name="date_naissance" />
                <input type="file" accept="image/*" placeholder="Photo de profil" name="photo_profil" />
                <button type="submit" name="formulaire_inscription">S'inscrire</button>
            </form>
        
        </div>
        <div class="form-container sign-in-container">
            <form method="POST" action="index.php?action=login">
                <h1>Se connecter</h1>
                <span>Entrer vos informations</span>
                <input type="email" placeholder="Email" name="adresse_email"/>
                <input type="password" placeholder="Mot de Passe" name="mot_de_passe"/>
                <a href="index.php?action=forgotpassword">Mot de passe oublié ?</a>
                <button name="formulaire_connexion">Se connecter</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Déjà inscrit ?</h1>
                    <p>Connectez-vous !</p>
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
