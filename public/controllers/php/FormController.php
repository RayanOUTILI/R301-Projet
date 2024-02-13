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
                    session_start();
                    $_SESSION['adresse_email'] = $adresse_email;
                    $user_info = $this->getMainDao()->selectFrom("utilisateurs", "nom,prenom,date_naissance,adresse,telephone_portable,adresse_email_secours,photo_profil,id_utilisateur", "adresse_email = '$adresse_email'");
                    $_SESSION = array_merge($_SESSION, $user_info[0]);
                    $is_admin = $this->getMainDao()->checkIfAdmin($_SESSION['id_utilisateur']);
                    $_SESSION['is_admin'] = $is_admin;
                    $GLOBALS['is_connected'] = true;
                    header("Location: index.php?action=profile");

                } else {
                    $this->formView->displayError("Le mot de passe est incorrect");
                }
            } else {
                $this->formView->displayError("Cette adresse email n'existe pas");
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

            // on limite à 1 Mo
            if (isset($_FILES['photo_profil']['name']) && !empty($_FILES['photo_profil']['name']) && $_FILES['photo_profil']['size'] < 1000000) {
                $upload_folder = 'img/';
                $file_name = $_FILES['photo_profil']['name'];
                $upload_path = __DIR__ . '/' . $upload_folder . $file_name;

                //on créé le dossier s'il n'existe pas
                if (!is_dir(__DIR__ . '/' . $upload_folder)) {
                    mkdir(__DIR__ . '/' . $upload_folder, 0755, true);
                }

                //chemin du projet pour suppr le chemin absolu apre
                $project_root = '/home/or201305/www/R301-Projet/';

                // on suppr ce qui suit public
                $relative_path = str_replace($project_root, '', $upload_path);

                if ($_FILES['photo_profil']['error'] !== UPLOAD_ERR_OK) {
                    echo "Upload error: " . $_FILES['photo_profil']['error'];
                } elseif (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $upload_path)) {
                    echo "ok";
                } else {
                    echo "Erreur de téléchargement !\n";
                }
            } else {
                echo "Erreur de téléchargement, fichier trop volumineux (1 Mo maximum) !\n";
            }



            $checkIfEmailExists = $this->getMainDao()->checkIfEmailExists("utilisateurs", $adresse_email);
            if ($checkIfEmailExists == false) {
                $this->getMainDao()->insertInto
                (
                    "utilisateurs",
                    array("nom", "prenom", "adresse_email", "adresse_email_secours", "mot_de_passe", "adresse", "telephone_portable", "date_naissance", "photo_profil"),
                    array($nom, $prenom, $adresse_email, $email_secours, $mot_de_passe, $adresse, $telephone_portable, $date_naissance, 'public/controllers/php/img/' . $_FILES['photo_profil']['name'])
                );
                session_start();
                $_SESSION['adresse_email'] = $adresse_email;
                $user_info = $this->getMainDao()->selectFrom("utilisateurs", "nom,prenom,date_naissance,adresse,telephone_portable,adresse_email_secours,photo_profil,id_utilisateur", "adresse_email = '$adresse_email'");
                $_SESSION = array_merge($_SESSION, $user_info[0]);
                $is_admin = $this->getMainDao()->checkIfAdmin($_SESSION['id_utilisateur']);
                $_SESSION['is_admin'] = $is_admin;
                header("Location: index.php?action=feed");
                $GLOBALS['is_connected'] = true;
            } else {
                $this->formView->displayError("Cette adresse email est déjà utilisée");
            }

        }
    }

    public function render()
    {
        $variables =
            [
                "rien" => "rien"
            ];
        $this->formView->render($variables);
    }

}



?>