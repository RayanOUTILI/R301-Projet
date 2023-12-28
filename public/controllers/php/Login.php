<?php
/*
require '../../config/Config.php';
require '../../models/php/DAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse_email = $_POST['adresse_email'];
    $email_secours = $_POST['email_secours'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $adresse = $_POST['adresse'];
    $telephone_portable = $_POST['telephone_portable'];
    $date_naissance = $_POST['date_naissance'];

    if (isset($_FILES['photo_profil']) && !empty($_FILES['photo_profil']['name'])) {
        $photo_profil = $_FILES['photo_profil']['name'];
        $photo_profil_temp = $_FILES['photo_profil']['tmp_name'];

        $dossier_upload = __DIR__ . '/uploads/';
        $chemin_photo_profil = $dossier_upload . $photo_profil;

        move_uploaded_file($photo_profil_temp, $chemin_photo_profil);
    } else {
        $chemin_photo_profil = '';
    }

    $dao = new DAO(Config::DBHOST, Config::DBNAME, Config::DBUSERNAME, Config::DBPASSWORD);

    $values = "'$nom', '$prenom', '$adresse_email', '$email_secours', '$mot_de_passe', '$adresse', '$telephone_portable', '$date_naissance', '$chemin_photo_profil'";
    //$result = $dao->insertInto('utilisateurs', $values);

    header('Location: message.php');
    exit();
}*/
?>
