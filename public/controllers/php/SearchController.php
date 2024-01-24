<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/SearchView.php";
require_once __DIR__ . "/../../views/php/classes/FeedView.php";
require_once __DIR__ . "/../../views/php/classes/SearchByTime.php";


class SearchController extends Controller
{
    private $searchView;
    private $FeedView;
    private $searchByTime;
    public function __construct()
    {
        parent::__construct();
        $this->searchView = new SearchView();
        $this->FeedView = new FeedView();
        $this->searchByTime = new searchByTime();
    }

    public function render()
    {
        session_start();
        $variables = ["none" => "none"];
        $this->searchView->render($variables);
    }

    public function searchByTime()
    {
        session_start();
        $dateDebut = $_POST['dateDebut'];
        $dateFin = $_POST['dateFin'];
        $publications = $this->getMainDao()->getPublicationsByTime($dateDebut, $dateFin);
        foreach ($publications as &$publication) {
            $publication["nom"] = $this->_mainDao->getAuthorSurname($publication['id_publication']);
            $publication["prenom"] = $this->_mainDao->getAuthorName($publication['id_publication']);
            $publication["photo_profil"] = $this->_mainDao->getAuthorPhoto($publication['id_publication']);
            $publication["link_img"] = $this->_mainDao->getLinkImages($publication['id_publication']);
            $publication["likes_count"] = $this->_mainDao->getNbLikes($publication['id_publication']);
            $publication["dislikes_count"] = $this->_mainDao->getNbDislikes($publication['id_publication']);
            $publication["comments_count"] = $this->_mainDao->getNbComments($publication['id_publication']);
            $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];
            $publication["isLike"] = $this->_mainDao->isLiked($user_id, $publication['id_publication']);
            $publication["isDislike"] = $this->_mainDao->isDisliked($user_id, $publication['id_publication']);
        }
        $variables = [
            "publications" => $publications
        ];
        // $this->searchView->render($variables);
        $this->searchByTime->render($variables);

    }


}

?>