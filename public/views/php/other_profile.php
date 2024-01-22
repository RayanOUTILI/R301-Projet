<body>
    <?php include_once('nav.php'); 
    $is_admin = $_SESSION["is_admin"];
    ?>

    <header>
        <div class="container">
            <div class="profile">
                <div class="profile-image">
                    <img src="<?php echo $photo_profil ?>" alt="">
                </div>
                <div class="profile-user-settings">
                    <h1 class="profile-user-name">
                        <?php echo $user["prenom"] . " " . $user["nom"] ?>
                    </h1>
                    <?php
                    
                        if($user["id_utilisateur"] == $_SESSION["id_utilisateur"])
                        {
                            echo "<form action='index.php?action=editprofile' method='POST'>";
                            echo "<button class='btn profile-edit-btn' name='editprofile'>Modifier Profil</button>";
                            echo "</form>";
                        }
                        else
                        {
                            if($is_friend)
                            {
                                echo "<form action='index.php?action=unfriend".$user["id_utilisateur"] ."' method='POST'>";
                                echo "<button class='btn profile-edit-btn' name='unfriend'>Supprimer l'ami</button>";
                                echo "</form>";
                            }
                            else
                            {
                                echo "<form action='index.php?action=addfriend". $user["id_utilisateur"]. "' method='POST'>";
                                echo "<button class='btn profile-edit-btn' name='addfriend'>Ajouter en ami</button>";
                                echo "</form>";
                            }
                        }

                    ?>
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
                foreach ($user_publications as $publication) 
                {
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
                     
                
                echo "<div class=\"gallery-item\" tabindex=\"0\">";
                if($is_admin)
                {
                    if($publication["est_bloque"] == 0)
                    {
                        {echo "<button class=\"profile-block-btn \" name=\"deletepublication\" id=". $publication["id_publication"] .">X</button>";}
                    }
                    else
                    {
                        {echo "<button class=\"profile-block-btn blocked\" name=\"deletepublication\" id=". $publication["id_publication"] .">&#10003</button>";}
                    }
                }
              
                echo "<img src=\"$link_img\">";
                
                echo "<div class=\"gallery-item-info\">
                    <ul>
                        <li class=\"gallery-item-likes\"><span class=\"visually-hidden\">Likes:</span><i class=\"fas fa-heart\" aria-hidden=\"true\"></i> $likes_count</li>
                        <li class=\"gallery-item-comments\"><span class=\"visually-hidden\">Comments:</span><i class=\"fas fa-comment\" aria-hidden=\"true\"></i> $comments_count</li>
                    </ul>
                </div>
              </div>";}
                ?>
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="public/views/js/block_content.js"></script>
            </div>
        </div>
    </main>
</body>

</html>