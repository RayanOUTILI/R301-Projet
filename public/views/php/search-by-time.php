<!DOCTYPE html>
<html lang="fr" id="search-by-time">


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
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];

} else {
    header("Location: index.php?action=form");
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/views/css/feed.css">
    <link rel="stylesheet" href="public/views/css/main.css">
    <link rel="stylesheet" href="public/views/css/nav.css">
    <link rel="stylesheet" href="public/views/css/pagination.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="public/views/js/pagination.js"></script>
    <script src="public/views/js/likes.js"></script>
    <script src="public/views/js/dislikes.js"></script>
    <title>Feed</title>
</head>

<body>
    <?php include_once('nav.php'); ?>

    <!-- on affiche la date des posts -->
    <div id="date">
        <p>
            <?php echo "Voici les publications pour la période suivante " . $dateDebut . " au " . $dateFin; ?>
        </p>
    </div>

    <div id="date">
        <p>
            <?php echo count($publications) . " publications trouvées"; ?>
        </p>
    </div>



    <div class="post-container">
        <?php
        foreach ($publications as $publication) {
            ?>
            <div class="post">

                <?php
                // on récupère les infos de l'auteur
                $nomAuteur = $publication['nom'];
                $prenomAuteur = $publication['prenom'];
                $photoProfil = $publication['photo_profil'];
                $idPost = $publication['id_publication'];
                $GLOBALS['id_post'] = $idPost;
                $textePost = $publication['texte'];
                $datePost = $publication['date_publication'];
                $likesCount = $publication['likes_count'];
                $dislikesCount = $publication['dislikes_count'];
                $commentsCount = $publication['comments_count'];
                $images = $publication['link_img'];
                $isLike = $publication['isLike'];
                $isDislike = $publication['isDislike'];
                ?>

                <div class="post-top">
                    <span class="avatar">
                        <img src="<?php echo '/~or201305/R301-Projet/' . $photoProfil; ?>" alt="Avatar">
                    </span>
                    <h1 class="title">
                        <p>
                            <?php echo $nomAuteur . ' ' . $prenomAuteur; ?>
                        </p>
                    </h1>
                </div>

                <div class="photo-post">
                    <?php

                    if ($images == "") {
                        echo "";
                    } else {
                        $mime = mime_content_type($images);
                        if ($mime == "video/mp4") {
                            echo "<video width='320' height='240' controls>";
                            echo "<source src='$images' type='video/mp4'>";
                            echo "</video>";
                        } else if (preg_match('/^image\/[a-z]+$/', $mime)) {
                            echo "<img src='$images' alt=''>";
                        }




                    }

                    ?>

                </div>

                <div class="post-middle">
                    <div class="icon like" data-id="<?php echo $idPost; ?>" id="likeBtn">
                        <?php
                        if ($isLike == 1) {
                            echo '<img src="' . $root_path . '/assets/img/like_red.png" alt="Like">';
                        } else {
                            echo '<img src="' . $root_path . '/assets/img/like.png" alt="Like">';
                        }
                        ?>
                    </div>
                    <div class="icon dislike" data-id="<?php echo $idPost; ?>" id="dislikeBtn">
                        <?php
                        if ($isDislike == 1) {
                            echo '<img src="' . $root_path . '/assets/img/dislike_red.png" alt="Dislike">';
                        } else {
                            echo '<img src="' . $root_path . '/assets/img/dislike.png" alt="Dislike">';
                        }
                        ?>
                    </div>
                    <div class="icon comment">
                        <img src="<?php echo $root_path . "/assets/img/comment.png" ?>" alt="Comment">
                    </div>
                    <div class="icon flag">
                        <img src="<?php echo $root_path . "/assets/img/bookmark.png" ?>" alt="BookMark">
                    </div>
                </div>

                <div class="post-bottom">
                    <h1 class="title likes">
                        <?php echo "<span data-id='$idPost' class='nbLikes'>$likesCount</span>"; ?> likes
                    </h1>
                    <h1 class="title likes">
                        <?php echo "<span data-id='$idPost' class='nbDislikes'>$dislikesCount</span>"; ?> dislikes
                    </h1>


                    <div class="text">
                        <span>
                            <p>
                                <?php echo $textePost; ?>
                            </p>
                        </span>
                    </div>

                    <div class="text2">
                        <p>
                            <?php echo $commentsCount; ?> commentaires
                        </p>
                    </div>

                    <div class="text2 date">
                        <p>
                            <?php echo $datePost; ?>
                        </p>
                    </div>
                </div>

            </div>
            <?php
        }
        ?>
    </div>


</body>

</html>