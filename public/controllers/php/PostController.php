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
        $this->postView->render();
    }

        
    public function createNewPost()
    {
        if (isset($_POST['submit_post'])) 
        {
            $this->postView->render();
            $user_id = $this->getMainDao()->selectFrom("utilisateurs", "id_utilisateur", "adresse_email = '" . $_SESSION['adresse_email'] . "'")[0]['id_utilisateur'];

            $post_title = $_POST['post_title'];
            $post_text = $_POST['post_text'];
            $post_visibility = $_POST['post_visibility'];

            $result = $this->getMainDao()->insertInto(
                "publications",
                array("id_utilisateur", "titre", "texte", "visibilite"),
                array($user_id, $post_title, $post_text, $post_visibility)
            );

            if ($result) {
                $last_inserted_id = $this->getMainDao()->getLastInsertedId();

                $upload_folder = 'uploads/';
                $post_images = [];

                if (!empty($_FILES['post_images']['name'][0])) 
                {
                    foreach ($_FILES['post_images']['tmp_name'] as $key => $tmp_name) 
                    {
                        $file_name = $_FILES['post_images']['name'][$key];
                        $upload_path = $upload_folder . $file_name;

                        move_uploaded_file($tmp_name, $upload_path);

                        $result_image = $this->getMainDao()->insertInto(
                            "images_publication",
                            array("id_publication", "photo_url"),
                            array($last_inserted_id, $upload_path)
                        );
                    }
                }

                echo "Post publié avec succès!";
            }
        }
    }
}

?>