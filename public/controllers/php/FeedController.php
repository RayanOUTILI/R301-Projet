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

        if (isset($_POST['page'])) {
            // echo "<script>console.log('icicici', " . json_encode($_POST["page"]) . ")</script>";
        }


        $totalPublications = $this->getMainDao()->getNbTotalPublications();
        $postsPerPage = 5;
        $totalPages = ceil($totalPublications / $postsPerPage);
        if (isset($_POST['page']) && $_POST['page'] > 0 && $_POST['page'] <= $totalPages) {
            $currentPage = $_POST['page'];
        } else {
            $currentPage = 1;
        }
        // on affiche le nombre de publications par page
        // echo "<script>console.log('icicici', " . json_encode($totalPublications) . ")</script>";
        // echo "<script>console.log('icicici', " . json_encode($postsPerPage) . ")</script>";
        $limited_publications = $this->getMainDao()->getPaginatedPublications($postsPerPage, $currentPage); //on limite le nombre de publications à 5 par page
        foreach ($limited_publications as &$publication) {
            $publication["nom"] = $this->_mainDao->getAuthorSurname($publication['id_publication']);
            $publication["prenom"] = $this->_mainDao->getAuthorName($publication['id_publication']);
            $publication["adresse_email"] = $this->_mainDao->getAuthorEmail($publication['id_publication']);
            $publication["photo_profil"] = $this->_mainDao->getAuthorPhoto($publication['id_publication']);
            $publication["link_img"] = $this->_mainDao->getLinkImages($publication['id_publication']);
            $publication["likes_count"] = $this->_mainDao->getNbLikes($publication['id_publication']);
            $publication["dislikes_count"] = $this->_mainDao->getNbDislikes($publication['id_publication']);
            $publication["comments_count"] = $this->_mainDao->getNbComments($publication['id_publication']);
            $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];
            $publication["isLike"] = $this->_mainDao->isLiked($user_id, $publication['id_publication']);
            $publication["isDislike"] = $this->_mainDao->isDisliked($user_id, $publication['id_publication']);
            $publication['visibilite'] = $this->_mainDao->getVisibility($publication['id_publication']);
        }

        // on filtre les publications selon la visibilité (public ou pas) 
        // + si le post a été bloqué 
        $limited_publications = array_filter($limited_publications, function ($publication) {
            // si le post a été bloqué on ne l'affiche pas
            // echo "<script>console.log('icicici', " . json_encode($publication['texte']) . ")</script>";
            if ($this->getMainDao()->isBlocked($publication['id_publication'])) {
                // echo "<script>console.log('bloqué')</script>";
                return false;
            }
            // si l'auteur du post a été bloqué 
            if ($this->getMainDao()->isBlockedUser($publication['adresse_email'])) {
                // echo "<script>console.log('bloqué2')</script>";
                return false;
            }
            // si c'est mon post on retourne true
            if ($publication['adresse_email'] == $_SESSION['adresse_email']) {
                // echo "<script>console.log('mon post')</script>";
                return true;
            }
            // echo "<script>console.log('pas mon post')</script>";
            return $publication['visibilite'] == 'public' || $this->getMainDao()->areTheyFriends($_SESSION['adresse_email'], $publication['adresse_email']);
        });

        $variables = [
            "limited_publications" => $limited_publications,
            "totalPages" => $totalPages,
            "currentPage" => $currentPage
        ];
        $this->FeedView->render($variables);

    }


    public function postLiked()
    {
        $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];
        if (isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
        }
        // si l'utilisateur n'a pas encore liké la publication
        if (!$this->getMainDao()->selectFrom("appreciations", "*", "id_utilisateur = $user_id AND id_publication = $post_id AND type = 'like'")) {
            $this->likePost($user_id, $post_id);
        } else {
            $this->unlikePost($user_id, $post_id);
        }
    }

    public function postDisliked()
    {
        $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];
        if (isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
        }
        // si l'utilisateur n'a pas encore disliké la publication
        if (!$this->getMainDao()->selectFrom("appreciations", "*", "id_utilisateur = $user_id AND id_publication = $post_id AND type = 'dislike'")) {
            $this->dislikePost($user_id, $post_id);
        } else {
            $this->undislikePost($user_id, $post_id);
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
        $this->getMainDao()->deleteFrom("appreciations", "id_utilisateur = $user_id AND id_publication = $post_id AND type = like");
    }

    public function dislikePost($user_id, $post_id)
    {
        $this->getMainDao()->insertInto(
            "appreciations",
            array("id_utilisateur", "id_publication", "type", "commentaire"),
            array($user_id, $post_id, "dislike", null)
        );
    }

    public function undislikePost($user_id, $post_id)
    {
        $this->getMainDao()->deleteFrom("appreciations", "id_utilisateur = $user_id AND id_publication = $post_id AND type = dislike");
    }


}