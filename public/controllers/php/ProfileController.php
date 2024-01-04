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
        $GLOBALS["nb_user_publications"] = $this->_mainDao->getNbPublications($_SESSION['id_utilisateur']);
        $user_publications = $this->_mainDao->getPublication($_SESSION['adresse_email']);
        $GLOBALS["user_publications"] = array();
        foreach ($user_publications as $user_publication) {
            $GLOBALS["user_publications"][] = $user_publication;
        }
        foreach ($user_publications as $publication) {
            $link_img = $this->_mainDao->getLinkImages($user_publications['id_publication']);
            $GLOBALS[$publication]["link_img"] = (string) $link_img;
            $likes_count = $this->_mainDao->getNbLikes($user_publications['id_publication']);
            $GLOBALS[$publication]["likes_count"] = $likes_count;
            $comments_count = $this->_mainDao->getNbComments($user_publications['id_publication']);
            $GLOBALS[$publication]["comments_count"] = $comments_count;
        }

        $this->profileView->render();

    }

}

?>