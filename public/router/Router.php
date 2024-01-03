<?php

require_once __DIR__ . "/../controllers/php/FormController.php";

class Router
{
    private $formController;

    public function __construct()
    {
        $this->formController = new FormController();
    }

    public function route()
    {
        if(isset($GLOBALS['action']))
        {
            $action = $GLOBALS['action'];
            switch($action)
            {
                case "validateLoginForm":
                    $this->formController->validateLoginForm();
                    break;
                case "validateSignupForm":
                    $this->formController->validateSignupForm();
                    break;
                case "loginConfirmed":
                case "signupConfirmed":
                    header("Location: /public/views/php/user_profile.php");
                    break;
                case "createNewPost":
                    echo "Création d'un nouveau post";
                    $this->formController->createNewPost();
                    break;
                default:
                    $this->formController->validateLoginForm();
                    break;
            }
        }
        else
        {
            $this->formController->validateLoginForm();
        }
    }


}

?>