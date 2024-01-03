<?php

require_once __DIR__ . "/../controllers/php/FormController.php";
require_once __DIR__ . "/../controllers/php/PostController.php";
require_once __DIR__ . "/../interfaces/IObserver.php";

class Router implements IObserver
{
    private $formController;
    private $postController;

    public function __construct()
    {
        $this->formController = new FormController();
        $this->postController = new PostController();

        $this->formController->attach($this);
        $this->postController->attach($this);
    }

    public function update($data)
    {
        switch($data)
        {
            case "validateLoginForm":
                $this->formController->validateLoginForm();
                break;
            case "validateSignupForm":
                $this->formController->validateSignupForm();
                break;
            case "loginConfirmed":
            case "signupConfirmed":
                header("Location: ./public/views/php/user_profile.php");
                break;
            case "createNewPost":
                $this->postController->createNewPost();
                break;
            default:
                break;
        }
    }



}
?>