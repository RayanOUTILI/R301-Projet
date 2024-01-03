<!DOCTYPE html>
<html lang="fr">

<?php
session_start();
if (isset($_SESSION['adresse_email'])) {
    $adresse_email = $_SESSION['adresse_email'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $adresse = $_SESSION['adresse'];
    $telephone_portable = $_SESSION['telephone_portable'];
    $date_naissance = $_SESSION['date_naissance'];
    $adresse_email_secours = $_SESSION['adresse_email_secours'];
    $photo_profil = $_SESSION['photo_profil'];

    $totalPublications = $dao->getTotalPublications();
    $postsPerPage = 5;
    $totalPages = ceil($totalPublications / $postsPerPage);

    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $totalPages) {
        $currentPage = $_GET['page'];
    } else {
        $currentPage = 1;
    }

    $limited_publications = $dao->getPaginatedPublications($postsPerPage, $currentPage); //on limite le nombre de publications à 5 par page
} else {
    // header("Location: index.php");
    // exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/feed.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/pagination.js"></script>
    <title>Feed</title>
</head>

<body>
    <?php include_once('nav.php'); ?>

    <div class="post-container">
        <?php
        foreach ($limited_publications as $publication) {
            ?>
            <div class="post">

                <?php
                // on récupère les infos de l'auteur
                $nomAuteur = $publication['nom'];
                $prenomAuteur = $publication['prenom'];
                $photoProfil = $publication['photo_profil'];
                $idPost = $publication['id_publication'];
                $textePost = $publication['texte'];
                $datePost = $publication['date_publication'];
                $likesCount = $dao->getNbLikes($idPost);
                $commentsCount = $dao->getNbComments($idPost);
                $images = $dao->getLinkImages($idPost);
                ?>
                <!-- $nomAuteur = "Rayan Outili"; // .post-container $post->getNom() et $post->getPrenom()
                $photoProfil = "/assets/img/like.png"; // .post-container $post->getPhotoProfil()
                $photoPost = "/assets/img/feed_sample.webp"; // .post-container $post->getPhoto()
                $textePost = "John wick c'est vraiment trop bien !!!!"; // .post-container $post->getTexte()
                $datePost = "Il y a 6 jours"; // .post-container $post->getDate()
                $likesCount = 10; // .post-container le nombre réel de likes -->

                <div class="post-top">
                    <span class="avatar">
                        <img src="<?php echo 'img/' . $photoProfil; ?>" alt="Avatar">
                    </span>
                    <h1 class="title">
                        <p>
                            <?php echo $nomAuteur . $prenomAuteur; ?>
                        </p>
                    </h1>
                </div>

                <div class="photo-post">
                    <?php
                    foreach ($images as $image) {
                        ?>
                        <img src="<?php echo 'img/' . $image['photo_url']; ?>" alt="Photo">
                        <?php
                    }
                    ?>
                </div>

                <div class="post-middle">
                    <div class="icon like">
                        <img src="/assets/img/like.png" alt="Like">
                    </div>
                    <div class="icon comment">
                        <img src="/assets/img/comment.png" alt="Comment">
                    </div>
                    <div class="icon flag">
                        <img src="/assets/img/bookmark.png" alt="Bookmark">
                    </div>
                </div>

                <div class="post-bottom">
                    <h1 class="title likes">
                        <?php echo $likesCount; ?> likes
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

    <div class="pagination">
        <?php if ($totalPages > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>" class="pagination-link" <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>>&laquo; Page précédente</a>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="pagination-link" <?php echo ($i == $currentPage) ? 'active' : ''; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            <a href="?page=<?php echo $currentPage + 1; ?>" class="pagination-link" <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>>Page suivante &raquo;</a>
        <?php endif; ?>
    </div>
</body>

</html>