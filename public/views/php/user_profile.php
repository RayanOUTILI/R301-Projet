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
    $is_admin = $_SESSION['is_admin'];

}
require_once __DIR__ . "/headers/profileheader.php";
?>



<body>
    <?php
    include_once('nav.php'); ?>

    <header>
        <div class="container">
            <div class="profile">
                <div class="profile-image">
                    <img src="<?php echo $photo_profil ?>" alt="">
                </div>
                <div class="profile-user-settings">
                    <h1 class="profile-user-name">
                        <?php echo $prenom . " " . $nom ?>
                    </h1>
                    <form action='index.php?action=editprofile' method='POST'>
                    <button class="btn profile-edit-btn" name="editprofile">Modifer profil</button>
                    </form>
                
                </div>
                <div class="profile-stats">
                    <ul>
                        <li><span class="profile-stat-count">
                                <?php echo $nb_user_publications ?>
                            </span> Publications</li>
                        <li><span class="profile-stat-count">
                                <?php echo $nb_user_friends ?>
                        </span> Amis</li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>

        <div class="container">
            <div class="gallery">
                <?php
                
                foreach ($user_publications as $publication) {
                    if($publication["est_bloque"] == 1 && $is_admin == 0)
                    {
                        continue;
                    }
                    if (isset($publication["link_img"])) {
                        $link_img = $publication["link_img"];
                    } else {
                        $link_img = "";
                    }
                    if (isset($publication["likes_count"])) {
                        $likes_count = $publication["likes_count"];
                    } else {
                        $likes_count = "";
                    }
                    if (isset($publication["comments_count"])) {
                        $comments_count = $publication["comments_count"];
                    } else {
                        $comments_count = "";
                    }
                    echo "<div class=\"gallery-item\" tabindex=\"0\">
                <img src=\"$link_img\">
                <div class=\"gallery-item-info\">
                    <ul>
                        <li class=\"gallery-item-likes\"><span class=\"visually-hidden\">Likes:</span><i class=\"fas fa-heart\" aria-hidden=\"true\"></i> $likes_count</li>
                        <li class=\"gallery-item-comments\"><span class=\"visually-hidden\">Comments:</span><i class=\"fas fa-comment\" aria-hidden=\"true\"></i> $comments_count</li>
                    </ul>
                </div>
              </div>";
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>