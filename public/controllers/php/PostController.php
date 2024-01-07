<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/PostView.php";

class PostController extends Controller
{
    private $postView;

    public function __construct()
    {
        parent::__construct();
        $this->postView = new PostView();
    }

    public function render()
    {
        $rien = ["rien" => "rien"];
        $this->postView->render($rien);
    }


    public function createNewPost()
    {
        if (isset($_POST['submit_post'])) {
            
            $this->render();
            $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];

            $post_title = $_POST['post_title'];
            $post_text = $_POST['post_text'];
            $post_visibility = $_POST['post_visibility'];

            $result = $this->getMainDao()->insertInto(
                "publications",
                array("id_utilisateur", "titre", "texte", "visibilite"),
                array($user_id, $post_title, $post_text, $post_visibility)
            );

            $last_inserted_id = $this->getMainDao()->getLastInsertedId();

            if (isset($_FILES['post_images']['name'][0]) && !empty($_FILES['post_images']['name'][0])) {
                $upload_folder = 'img/';
                $file_name = $_FILES['post_images']['name'][0];
                $upload_path = __DIR__ . '/' . $upload_folder . $file_name;

                //on créé le dossier s'il n'existe pas
                if (!is_dir(__DIR__ . '/' . $upload_folder)) {
                    mkdir(__DIR__ . '/' . $upload_folder, 0755, true);
                }

                //chemin du projet pour suppr le chemin absolu apre
                $project_root = '/home/or201305/www/R102/TD5/js/social-network/';

                // on suppr ce qui suit public
                $relative_path = str_replace($project_root, '', $upload_path);

                $this->getMainDao()->insertInto(
                    "images_publication",
                    array("id_publication", "photo_url"),
                    array($last_inserted_id, $relative_path)
                );

                if ($_FILES['post_images']['error'][0] !== UPLOAD_ERR_OK) {
                    echo "Upload error: " . $_FILES['post_images']['error'][0];
                } elseif (move_uploaded_file($_FILES['post_images']['tmp_name'][0], $upload_path)) {
                    echo "ok";
                } else {
                    echo "Erreur de téléchargement !\n";
                }
            }
        }
    }
}

?>