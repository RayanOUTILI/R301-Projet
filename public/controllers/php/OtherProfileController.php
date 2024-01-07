<?php
require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/OtherProfileView.php";

class OtherProfileController extends Controller
{
    private $otherProfileView;
    public function __construct()
    {
        parent::__construct();
        $this->otherProfileView = new OtherProfileView();
    }

    public function render($id)
    {
        
        if($this->_mainDao->doUserExist($id) == false)
        {
            header("Location: index.php?action=feed");
        }
        $idProfile = $id;
        $mail = $this->_mainDao->selectFrom("utilisateurs", "adresse_email", "id_utilisateur=$idProfile")[0]["adresse_email"];
        $publications = $this->_mainDao->getPublication($mail);
        $user = $this->_mainDao->selectFrom("utilisateurs", "*", "id_utilisateur=$idProfile")[0];
        $photo_profil = $user["photo_profil"];
        $nb_user_publications = $this->_mainDao->getNbPublications($user['adresse_email']);
        $nb_user_friends = $this->_mainDao->getNbFriends($user['adresse_email']);
        foreach ($publications as &$publication) 
        {
            $publication["link_img"] = $this->_mainDao->getLinkImages($publication['id_publication']);
            $publication["likes_count"] = $this->_mainDao->getNbLikes($publication['id_publication']);
            $publication["comments_count"] = $this->_mainDao->getNbComments($publication['id_publication']);
        }
        $is_friend = $this->_mainDao->isFriend($_SESSION['adresse_email'],$user['adresse_email']);
        $this->otherProfileView->renderProfile($user, $publications, $photo_profil, $nb_user_publications, $nb_user_friends, $is_friend);
        

    }

}







?>