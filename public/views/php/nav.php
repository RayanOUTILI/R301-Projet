<nav id="menu">
    <form method="POST" id="search" action="">
        <div class="search-box">
            <input type="text" name="request" placeholder="Rechercher...">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <ul>
        <li>
            <a href="./user_profile.php">
                <div class="icon">
                    <img src="<?php echo $GLOBALS["ROOT_PATH"] . "/assets/img/profil.png"?>" alt="Home">
                </div>
            </a>
        </li>
        <li>
            <a href="./feed.php">
                <div class="icon">
                    <img src="<?php echo __DIR__ . "/assets/img/feed_sample.webp"?>" alt="Search">
                </div>
            </a>
        </li>
        <li>
            <a href="./people.php">
                <div class="icon">
                    <img src="<?php echo __DIR__ . "/assets/img/add.png"?>" alt="Add">
                </div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="icon">
                    <img src="/assets/img/heart.png" alt="Heart">
                </div>
            </a>
        </li>
        <li>
            <a href="./user_profile.php">
                <div class="icon">
                    <img src="/assets/img/profil.png" alt="Profil">
                </div>
            </a>
        </li>
    </ul>
</nav>