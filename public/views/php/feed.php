<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/views/css/feed.css">
    <title>feed</title>
</head>

<body>
    <div class="post">

        <div class="post-top">
            <span class="avatar">
                <!-- avatar de la personne à l'origine du post -->
                <img src="/assets/img/like.png" alt="Avatar">
                <?php
                // echo "<img src='/assets/img/" . $post->getPhotoProfil() . "' alt='Avatar'>";
                ?>
            </span>
            <h1 class="title">
                <!-- nom de la personne à l'origine du post -->
                <p>Rayan Outili</p>
                <?php
                // echo "<p>" . $post->getNom() . " " . $post->getPrenom() . "</p>";
                ?>
            </h1>
        </div>

        <div class="photo-post">
            <!-- photo du post -->
            <img src="/assets/img/feed_sample.webp" alt="Photo">
            <?php
            // echo "<img src='/assets/img/" . $post->getPhoto() . "' alt='Photo'>";
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
                x likes
            </h1>

            <div class="text">
                <!-- texte du post -->
                <span>
                    <p>John wick c'est vraiment trop bien !!!!</p>
                </span>
                <?php
                // echo "<p>" . $post->getTexte() . "</p>";
                ?>
            </div>

            <div class="text2">
                <a href="#">Voir les x commentaires</a>
            </div>

            <div class="text2 date">
                <!-- date du post -->
                <p>Il y a 6 jours</p>
                <?php
                // echo "<p>" . $post->getDate() . "</p>";
                ?>
            </div>
        </div>

    </div>



</body>

</html>