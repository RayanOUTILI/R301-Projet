<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/FormView.php";
require_once __DIR__ . "/../../interfaces/IObservable.php";

class FormController extends Controller implements IObservable
{
    private $formView;
    private $observers = [];
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
            $checkIfEmailExists = $this->getMainDao()->checkIfEmailExists("utilisateurs",$adresse_email);
            if($checkIfEmailExists == true)
            {
                $checkIfPasswordMatches = $this->getMainDao()->checkIfPasswordMatches("utilisateurs",$adresse_email,$mot_de_passe);
                if($checkIfPasswordMatches == true)
                {
                    session_start();
                    $_SESSION['adresse_email'] = $adresse_email;
                    $user_info = $this->getMainDao()->selectFrom("utilisateurs","nom,prenom,date_naissance,adresse,telephone_portable,adresse_email_secours,photo_profil","adresse_email = '$adresse_email'");
                    $_SESSION = array_merge($_SESSION,$user_info[0]);
                    $this->notify("loginConfirmed");
                }
                else 
                {
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
            if ($checkIfEmailExists == false) 
            {
                $this->getMainDao()->insertInto
                (
                    "utilisateurs",
                    array("nom", "prenom", "adresse_email", "adresse_email_secours", "mot_de_passe", "adresse", "telephone_portable", "date_naissance"),
                    array($nom, $prenom, $adresse_email, $email_secours, $mot_de_passe, $adresse, $telephone_portable, $date_naissance)
                );
                $this->notify("signupConfirmed");
            } 
            else
            {
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

    public function attach(IObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(IObserver $observer)
    {
        $key = array_search($observer, $this->observers, true);
        if ($key) 
        {
            unset($this->observers[$key]);
        }
    }

    public function notify(string $action)
    {
        foreach ($this->observers as $observer)
        {
            $observer->update($action);
        }
    }
}



?>