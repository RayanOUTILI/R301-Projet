
<?php

class AdminBoardView extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../admin_board.php");
    }

    public function renderUserSearch($users)
    {
        $rien = ["rien"=>"rien"];
        $this->render($rien);
        echo "<div class='admin-search-results'>";
        foreach($users as $user)
        {
            foreach($user as $user)
            {
                $class = "";
                $status = "";
                if($user["est_bloque"] == 1)
                {
                    $class = "admin-blocked";
                    $status = "Bloqué";
                }
                else
                {
                    $class = "admin-notblocked";
                    $status = "Non bloqué";
                }
                
                echo "<div class='resultdiv' >";
                echo "<img src='" . $user['photo_profil'] . "' alt='photo de profil' class='resultimg' onclick='window.location.href=\"index.php?action='profile' ". $user['id_utilisateur'] . "\"'> ";
                echo "<div class='resultinfo' onclick='window.location.href=\"index.php?action=profile" . $user['id_utilisateur'] ."\"'>";
                echo "<p>". $user['nom'] . " " . $user['prenom'] ." </p>";
                echo "<p>" . $user['adresse_email']. "</p>";
                echo "<p></p>";
                echo "<p> Statut : <span class='$class'>" .$status . "</span></p>";
                echo "</div>";
                echo "<form action='" . $user["id_utilisateur"]."' method='POST'>";
                if($user["est_bloque"] == 0)
                    echo "<button class='bloquerprofil' type='submit' name='block_account'>Bloquer l'utilisateur</button>";
                else
                    echo "<button class='debloquerprofil' type='submit' name='unblock_account'>Débloquer l'utilisateur</button>";
                echo "<button class='supprimerprofil' type='submit' name='delete_account'>Supprimer l'utilisateur</button>";
                echo "<p>(Attention, cette action est irréversible)</p>";
                echo "</form>";
                echo "</div>";

            }
        }
        echo "</div>";
        
        echo "<script>

        const deleteButton = document.querySelectorAll('button.supprimerprofil');
        console.log(deleteButton);
        const blockButton = document.querySelectorAll('button.bloquerprofil');
        console.log(blockButton);
        const unblockButton = document.querySelectorAll('button.debloquerprofil');
        console.log(unblockButton);
        deleteButton.forEach((button) => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const confirmBox = confirm('Voulez-vous vraiment supprimer cet utilisateur ?');
                if(confirmBox)
                {
                    const form = button.parentElement;
                    form.setAttribute('action', 'index.php?action=deleteuser' + form.getAttribute('action'));
                    form.submit();
                }
            });
        });
        
        if(blockButton)
        {
            blockButton.forEach((button) => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const confirmBox = confirm('Voulez-vous vraiment bloquer cet utilisateur ?');
                    if(confirmBox)
                    {
                        const form = button.parentElement;;
                        form.setAttribute('action', 'index.php?action=blockuser' + form.getAttribute('action'));
                        form.submit();     
                    }
                });
            });
        }
        if(unblockButton)
        {
            unblockButton.forEach((button) => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const confirmBox = confirm('Voulez-vous vraiment débloquer cet utilisateur ?');
                    if(confirmBox)
                    {
                        const form = button.parentElement;
                        form.setAttribute('action', 'index.php?action=unblockuser' + form.getAttribute('action'));
                        form.submit();
                    }
                });
            });
        }
        
        
        </script>";

        require __DIR__ . "/../footers/indexfooter.php";

    }

    public function renderNoUserFound()
    {
        $rien = ["rien"=>"rien"];
        $this->render($rien);
        echo "<p>Aucun utilisateur trouvé</p>";
        require __DIR__ . "/../footers/indexfooter.php";
    }
}

?>