<?php
$root_path = __DIR__ . "/../../..";
$root_path = str_replace("home/", "~", $root_path);
$root_path = str_replace("/www", "", $root_path);

?>

<nav id="menu">
    <form method="POST" id="search" action="index.php?action=search">
        <div class="search-box">
            <input type="text" name="request" placeholder="Rechercher...">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <ul>
        <li>
            <a href="index.php?action=feed">
                <div class="icon">
                    <img src="<?php echo $root_path . "/assets/img/home.png" ?>" alt="Home">
                </div>
            </a>
        </li>
        <li>
            <a href="index.php?action=search">
                <div class="icon">
                    <img src="<?php echo $root_path . "/assets/img/search.png" ?>" alt="Search">
                </div>
            </a>
        </li>
        <li>
            <a href="index.php?action=post">
                <div class="icon">
                    <img src="<?php echo $root_path . "/assets/img/add.png" ?>" alt="Add">
                </div>
            </a>
        </li>
        <li>
            <a href="index.php?action=friends">
                <div class="icon">
                    <img src="<?php echo $root_path . "/assets/img/heart.png" ?>" alt="Heart">
                </div>
            </a>
        </li>
        <li>
            <a href="index.php?action=profile">
                <div class="icon">
                    <img src="<?php echo $root_path . "/assets/img/profil.png" ?>" alt="Profil">
                </div>
            </a>
        </li>
        <?php

        if ($_SESSION['is_admin'] == true) {
            echo '<li>
            <a href="index.php?action=admin">
                <div class="icon">
                    <img src="' . $root_path . '/assets/img/administrator.png" alt="Admin">
                </div>
            </a>
            </li>';
        }

        ?>
    </ul>
</nav>