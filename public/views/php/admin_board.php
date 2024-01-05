<?php require_once "./headers/adminheader.php"?>


<div class="admin-search-bar-box">
    <form action="index.php?action=adminsearch" method="POST"> 
        <input type="text" name="searchbar" id="searchbar" placeholder="Rechercher un utilisateur">
        <input type="submit" value="Rechercher" name="admin_user_search">
    </form>
</div>



<?php require_once "./footers/indexfooter.php"?>