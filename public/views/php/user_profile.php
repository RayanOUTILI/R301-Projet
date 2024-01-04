
<?php

if (isset($_SESSION['adresse_email'])) 
{
    $adresse_email = $_SESSION['adresse_email'];
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
    $adresse = $_SESSION['adresse'];
    $telephone_portable = $_SESSION['telephone_portable'];
    $date_naissance = $_SESSION['date_naissance'];
    $adresse_email_secours = $_SESSION['adresse_email_secours'];
    $photo_profil = $_SESSION['photo_profil'];

} 
require_once __DIR__ . "/headers/profileheader.php";

?>



<body>
    <?php include_once('nav.php'); ?>

    <header>
        <div class="container">
            <div class="profile">
                <div class="profile-image">
                    <img src="../img/<?php echo $photo_profil ?>" alt="">
                </div>
                <div class="profile-user-settings">
                    <h1 class="profile-user-name">
                        <?php echo $prenom . " " . $nom ?>
                    </h1>
                    <button class="btn profile-edit-btn" name="editprofile">Edit Profile</button>
                    <?php

                    if (isset($_POST['editprofile'])) 
                    {
                        header("Location: index.php?action=editprofile");
                    }
                    
                    ?>
                    <button class="btn profile-settings-btn" aria-label="profile settings"><i class="fas fa-cog"
                            aria-hidden="true"></i></button>
                </div>
                <div class="profile-stats">
                    <ul>
                        <li><span class="profile-stat-count"><?php echo $GLOBALS["nb_user_publications"]?></span> Publications</li>
                        <li><span class="profile-stat-count">x</span> Abonnés</li>
                        <li><span class="profile-stat-count">x</span> Abonnements</li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>

        <div class="container">
            <div class="gallery">
                <?php
                foreach ($GLOBALS["user_publications"] as $publication) {
                    $link_img = $publication["link_img"];
                    $likes_count = $publication["likes_count"];
                    $comments_count = $publication["comments_count"];

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

            <!-- <div class="gallery-item" tabindex="0">
                    <img src="https://images.unsplash.com/photo-1497445462247-4330a224fdb1?w=500&h=500&fit=crop"
                        class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i
                                    class="fas fa-heart" aria-hidden="true"></i> 89</li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i
                                    class="fas fa-comment" aria-hidden="true"></i> 5</li>
                        </ul>
                    </div>
                </div>
                <div class="gallery-item" tabindex="0">
                    <img src="https://images.unsplash.com/photo-1426604966848-d7adac402bff?w=500&h=500&fit=crop"
                        class="gallery-image" alt="">
                    <div class="gallery-item-type">
                        <span class="visually-hidden">Gallery</span><i class="fas fa-clone" aria-hidden="true"></i>
                    </div>
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i
                                    class="fas fa-heart" aria-hidden="true"></i> 42</li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i
                                    class="fas fa-comment" aria-hidden="true"></i> 1</li>
                        </ul>
                    </div>
                </div>
                <div class="gallery-item" tabindex="0">
                    <img src="https://images.unsplash.com/photo-1502630859934-b3b41d18206c?w=500&h=500&fit=crop"
                        class="gallery-image" alt="">
                    <div class="gallery-item-type">
                        <span class="visually-hidden">Video</span><i class="fas fa-video" aria-hidden="true"></i>
                    </div>

                    <div class="gallery-item-info">

                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i
                                    class="fas fa-heart" aria-hidden="true"></i> 38</li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i
                                    class="fas fa-comment" aria-hidden="true"></i> 0</li>
                        </ul>
                    </div>
                </div> -->
        </div>
    </main>
</body>

</html>