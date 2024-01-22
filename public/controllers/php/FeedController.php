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
            $publication["nom"] = $this->_mainDao->getAuthorSurname($publication['id_publication']);
            $publication["prenom"] = $this->_mainDao->getAuthorName($publication['id_publication']);
            $publication["photo_profil"] = $this->_mainDao->getAuthorPhoto($publication['id_publication']);
            $publication["link_img"] = $this->_mainDao->getLinkImages($publication['id_publication']);
            $publication["likes_count"] = $this->_mainDao->getNbLikes($publication['id_publication']);
            $publication["comments_count"] = $this->_mainDao->getNbComments($publication['id_publication']);
            $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];
            $publication["isLike"] = $this->_mainDao->isLiked($user_id, $publication['id_publication']);
        }

        $variables = [
            "limited_publications" => $limited_publications,
            "totalPages" => $totalPages,
            "currentPage" => $currentPage
        ];
        $this->FeedView->render($variables);
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


    public function postLiked()
    {
        $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];
        if (isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
        }
        // si l'utilisateur n'a pas encore liké la publication
        if (!$this->getMainDao()->selectFrom("appreciations", "*", "id_utilisateur = $user_id AND id_publication = $post_id")) {
            $this->likePost($user_id, $post_id);
        } else {
            $this->unlikePost($user_id, $post_id);
        }
    }

    public function likePost($user_id, $post_id)
    {
        $this->getMainDao()->insertInto(
            "appreciations",
            array("id_utilisateur", "id_publication", "type", "commentaire"),
            array($user_id, $post_id, "like", null)
        );
    }

    public function unlikePost($user_id, $post_id)
    {
        $this->getMainDao()->deleteFrom("appreciations", "id_utilisateur = $user_id AND id_publication = $post_id");
    }


}