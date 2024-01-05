<?php
require_once __DIR__ . "/../controllers/php/FormController.php";
require_once __DIR__ . "/../controllers/php/PostController.php";
require_once __DIR__ . "/../controllers/php/ProfileController.php";
require_once __DIR__ . "/../controllers/php/FeedController.php";
require_once __DIR__ . "/../controllers/php/AdminBoardController.php";

class Router
{
    private $formController;
    private $postController;
    private $profileController;
    private $feedController;
    private $adminBoardController;
    private $errorView;

    public function __construct()
    {
        $this->formController = new FormController();
        $this->postController = new PostController();
        $this->profileController = new ProfileController();
        $this->feedController = new FeedController();

    }

    public function route()
    {
        if (isset($_GET["action"])) 
        {
            switch ($_GET["action"]) 
            {
                case "form":
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
                case "publish":
                    $this->postController->createNewPost();
                    break;
                case "feed":
                    $this->feedController->render();
                    break;
                case "admin":
                    if($_SESSION['is_admin'] == true)
                        $this->adminBoardController->render();
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
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
