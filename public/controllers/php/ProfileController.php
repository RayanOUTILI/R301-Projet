<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/ProfileView.php";


class ProfileController extends Controller
{
    private $profileView;
    public function __construct()
    {
        parent::__construct();
        $this->profileView = new ProfileView();
    }

    public function render()
    {
        session_start();
        $nb_user_publications = $this->_mainDao->getNbPublications($_SESSION['adresse_email']);
        $nb_user_friends = $this->_mainDao->getNbFriends($_SESSION['adresse_email']);
        $user_publications = $this->_mainDao->getPublication($_SESSION['adresse_email']); 
        foreach ($user_publications as &$publication) 
        {
            $publication["link_img"] = $this->_mainDao->getLinkImages($publication['id_publication']);
            $publication["likes_count"] = $this->_mainDao->getNbLikes($publication['id_publication']);
            $publication["comments_count"] = $this->_mainDao->getNbComments($publication['id_publication']);
        }
        $variables = [
            "nom" => $_SESSION['nom'],
            "prenom" => $_SESSION['prenom'],
            "photo_profil" => $_SESSION['photo_profil'],
            "nb_user_publications" => $nb_user_publications,
            "nb_user_friends" => $nb_user_friends,
            "user_publications" => $user_publications
        ];
        

        $GLOBALS["user_publications"] = $user_publications;
       
        $this->profileView->render($variables);


    }

}

?>