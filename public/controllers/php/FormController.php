<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/FormView.php";

class FormController extends Controller
{
    private $formView;
    public function __construct()
    {
        parent::__construct();
        $this->formView = new FormView();
        $this->formView->render();
    }

    public function validateLoginForm()
    {
        if (isset($_POST['formulaire_connexion'])) {
            $this->cleanFormInput();
            $adresse_email = $_POST['adresse_email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $checkIfEmailExists = $this->getMainDao()->checkIfEmailExists("utilisateurs", $adresse_email);
            if ($checkIfEmailExists == true) {
                $checkIfPasswordMatches = $this->getMainDao()->checkIfPasswordMatches("utilisateurs", $adresse_email, $mot_de_passe);
                if ($checkIfPasswordMatches == true) {
                    echo "Vous êtes connecté";
                    header("Location: ./public/views/php/user_profile.php");

                } else {
                    $this->formView->displayFormError("Le mot de passe est incorrect");
                }
            } else {
                $this->formView->displayFormError("Cette adresse email n'existe pas");
            }

        }


    }

    public function validateSignupForm()
    {
        if (isset($_POST['formulaire_inscription'])) {
            $this->cleanFormInput();
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $adresse_email = $_POST['adresse_email'];
            $email_secours = $_POST['email_secours'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $adresse = $_POST['adresse'];
            $telephone_portable = $_POST['telephone_portable'];
            $date_naissance = $_POST['date_naissance'];

            $checkIfEmailExists = $this->getMainDao()->checkIfEmailExists("utilisateurs", $adresse_email);
            if ($checkIfEmailExists == false) {
                $this->getMainDao()->insertInto
                (
                    "utilisateurs",
                    array("nom", "prenom", "adresse_email", "adresse_email_secours", "mot_de_passe", "adresse", "telephone_portable", "date_naissance"),
                    array($nom, $prenom, $adresse_email, $email_secours, $mot_de_passe, $adresse, $telephone_portable, $date_naissance)
                );
            } else {
                $this->formView->displayFormError("Cette adresse email est déjà utilisée");
            }

        }
    }

    public function cleanFormInput()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value);
            $_POST[$key] = trim($value);
            $_POST[$key] = stripslashes($value);
        }
    }


    public function createNewPost()
    {
        if (isset($_POST['submit_post'])) {

            $user_id = 1;

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

                if (!empty($_FILES['post_images']['name'][0])) {
                    foreach ($_FILES['post_images']['tmp_name'] as $key => $tmp_name) {
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