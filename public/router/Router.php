<?php

require_once __DIR__ . "/../controllers/php/FormController.php";
require_once __DIR__ . "/../controllers/php/PostController.php";
require_once __DIR__ . "/../controllers/php/ProfileController.php";

class Router
{
    private $formController;
    private $postController;
    private $profileController;

    public function __construct()
    {
        $this->formController = new FormController();
        $this->postController = new PostController();
        $this->profileController = new ProfileController();
       
    }

    public function route()
    {
        if (isset($_GET["action"]))
        {
            switch ($_GET["action"])
            {
                case "form":
                    echo "form";
                    $this->formController->render();
                    break;
                case "login":
                    $this->formController->validateLoginForm();
                    break;
                case "signup":
                    $this->formController->validateSignupForm();
                    break;
                case "profile":
                    $this->profileController->render();
                    break;
                case "post":
                    $this->postController->render();
                    break;
                default:
                    $this->formController->render();
                    break;
            }
        }
        else
        {
            $this->formController->render();
        }
    }



}
?>