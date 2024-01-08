<!DOCTYPE html>
<html lang="fr">

<?php
if (isset($_SESSION['adresse_email'])) {
    $adresse_email = $_SESSION['adresse_email'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $adresse = $_SESSION['adresse'];
    $telephone_portable = $_SESSION['telephone_portable'];
    $date_naissance = $_SESSION['date_naissance'];
    $adresse_email_secours = $_SESSION['adresse_email_secours'];
    $photo_profil = $_SESSION['photo_profil'];

} else {
    header("Location: index.php?action=form");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/views/css/friends.css">
    <link rel="stylesheet" href="public/views/css/main.css">
    <link rel="stylesheet" href="public/views/css/nav.css">
    <link rel="stylesheet" href="public/views/css/pagination.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="public/views/js/pagination.js"></script>
    <script src="public/views/js/friends.js"></script>
    <title>Demande d'amis</title>
</head>

<body>
    <?php include_once('nav.php'); ?>

    <div class="friend-requests">
        <?php

        // print_r($friends_request);
        
        if (empty($friends_request)) {
            echo '<div class="no-friend-request">Vous n\'avez aucune demande d\'amis.</div>';
        } else {
            foreach ($friends_request as $request) {
                $form = '<form action="index.php?action=friends-request" method="POST">';
                $friendBox = '<div class="friend-box">';
                $img = '<div class="friend-profile" style="background-image: url(' . $request['photo_profil'] . ');"></div>';
                $name = '<div class="name-box">' . $request['nom'] . ' ' . $request['prenom'] . '</div>';
                $username = '<div class="user-name-box">vous a envoyé une demande d\'amis.</div>';
                $rBtnRow = '<div class="request-btn-row" data-username="' . $request['prenom'] . '">';
                $accept = '<button name="accept" class="friend-request accept-request" data-username="' . $request['prenom'] . '">Accepter</button>';
                $decline = '<button name="decline" class="friend-request decline-request" data-username="' . $request['prenom'] . '">Refuser</button>';
                $rBtnRow .= $accept . $decline;
                $rBtnRow .= '</div>';
                $form .= $friendBox . $img . $name . $username . $rBtnRow . '</div>';

                // on créé un input caché pour récupérer le nom de l'utilisateur qui a envoyé la demande
                $form .= '<input type="hidden" name="username" value="' . $request['id_utilisateur'] . '">';

                echo $form;
            }
        }
        ?>
    </div>

    <div class="friend-list"></div>

</body>

</html>