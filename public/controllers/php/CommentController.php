<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/Comment.php";

class CommentController extends Controller
{
    private $commentView;
    public $postId;
    public function __construct()
    {
        parent::__construct();
        $this->commentView = new Comment();
    }

    public function render()
    {
        $variables = ["none" => "none"];
        // $this->commentView->render($variables);
    }

    public function renderId($id)
    {
        $this->postId = $id;

        echo '<div id="commentModal" class="modal">';
        echo '    <div class="modal-content">';
        echo '        <h2>Ajouter un commentaire</h2>';
        echo '        <form id="commentForm" action="index.php?action=comment" method="POST">';
        echo '            <textarea name="commentText" placeholder="Écrivez votre commentaire ici..." required></textarea>';
        echo '            <input type="hidden" name="postId" value="' . $this->postId . '">';
        echo '            <button type="submit">Ajouter</button>';
        echo '        </form>';
        echo '    </div>';
        echo '</div>';

    }

    public function createNewComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $texte = $_POST['commentText'];
            $postId = $_POST['postId'];
        }
        $idUtilisateur = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];
        $this->getMainDao()->createNewComment($idUtilisateur, $postId, $texte);

        header("Location: index.php?action=feed");
    }

    public function displayComments($postId)
    {
        $comments = $this->getMainDao()->getComments($postId);

        $comments = array_filter($comments, function ($comment) {
            return !empty($comment['commentaire']);
        });

        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $user = $this->getMainDao()->selectFrom("utilisateurs", "nom", "id_utilisateur = " . $comment['id_utilisateur'])[0];
                $commentaire = $comment['commentaire'];
                $date = $comment['date_appreciation'];
            }

            $variables = [
                "comments" => $comments,
                "user" => $user,
                "commentaire" => $commentaire,
                "date" => $date
            ];

            $this->commentView->render($variables);
        } else {
            $this->commentView->render(["rien" => "rien"]);
        }



    }






}

?>