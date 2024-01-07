<?php require_once "headers/adminheader.php"?>
<?php require_once "nav.php"?>

<div class="admin-search-bar-box">
    <form action="index.php?action=adminsearch" method="POST"> 
        <input type="text" name="searchbar" id="searchbar" placeholder="Rechercher un utilisateur">
        <input type="checkbox" name="" id="">
        <button type="submit" name="admin_user_search" id="admin_user_search">Rechercher</button>
    </form>
</div>



<?php require_once "footers/indexfooter.php"?>