<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/FeedView.php";

class FeedController extends Controller
{
    private $FeedView;
    public function __construct()
    {
        parent::__construct();
        $this->FeedView = new FeedView();
    }

    public function render()
    {
        session_start();
        $totalPublications = $this->getMainDao()->getNbPublications($_SESSION['adresse_email']);
        $postsPerPage = 5;
        $totalPages = ceil($totalPublications / $postsPerPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $totalPages) {
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }
        $limited_publications = $this->getMainDao()->getPaginatedPublications($postsPerPage, $currentPage); //on limite le nombre de publications à 5 par page
        foreach ($limited_publications as &$publication) {
            echo "<script>console.log('" . $publication['id_publication'] . "');</script>";
            $publication["nom"] = $this->_mainDao->getAuthorSurname($publication['id_publication']);
            $publication["prenom"] = $this->_mainDao->getAuthorName($publication['id_publication']);
            $publication["photo_profil"] = $this->_mainDao->getAuthorPhoto($publication['id_publication']);
            $publication["link_img"] = $this->_mainDao->getLinkImages($publication['id_publication']);
            $publication["likes_count"] = $this->_mainDao->getNbLikes($publication['id_publication']);
            $publication["comments_count"] = $this->_mainDao->getNbComments($publication['id_publication']);
        }
        $GLOBALS['limited_publications'] = $limited_publications;
        $GLOBALS['totalPages'] = $totalPages;
        $GLOBALS['currentPage'] = $currentPage;


        $this->FeedView->render();
        // session_start();
        // if (isset($_SESSION['adresse_email'])) {
        //     $adresse_email = $_SESSION['adresse_email'];
        //     $nom = $_SESSION['nom'];
        //     $prenom = $_SESSION['prenom'];
        //     $adresse = $_SESSION['adresse'];
        //     $telephone_portable = $_SESSION['telephone_portable'];
        //     $date_naissance = $_SESSION['date_naissance'];
        //     $adresse_email_secours = $_SESSION['adresse_email_secours'];
        //     $photo_profil = $_SESSION['photo_profil'];

        //     $totalPublications = $this->getMainDao()->getNbPublications($adresse_email);
        //     $postsPerPage = 5;
        //     $totalPages = ceil($totalPublications / $postsPerPage);

        //     if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $totalPages) {
        //         $currentPage = $_GET['page'];
        //     } else {
        //         $currentPage = 1;
        //     }

        //     $limited_publications = $this->getMainDao()->getPaginatedPublications($postsPerPage, $currentPage); //on limite le nombre de publications à 5 par page
        // } 


    }

}

?>