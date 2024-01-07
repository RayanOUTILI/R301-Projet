<?php
require_once __DIR__ . "/../controllers/php/FormController.php";
require_once __DIR__ . "/../controllers/php/PostController.php";
require_once __DIR__ . "/../controllers/php/ProfileController.php";
require_once __DIR__ . "/../controllers/php/FeedController.php";
require_once __DIR__ . "/../controllers/php/AdminBoardController.php";
require_once __DIR__ . "/../controllers/php/FriendsController.php";

class Router
{
    private $formController;
    private $postController;
    private $profileController;
    private $feedController;
    private $adminBoardController;
    private $errorView;
    private $friendsController;

    public function __construct()
    {
        $this->formController = new FormController();
        $this->postController = new PostController();
        $this->profileController = new ProfileController();
        $this->feedController = new FeedController();
        $this->friendsController = new FriendsController();
        $this->adminBoardController = new AdminBoardController();

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
                case "friends":
                    $this->friendsController->render();
                    break;
                case "admin":
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->adminBoardController->render();
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                case "adminsearch":
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->adminBoardController->submitForm();
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                case preg_match("/deleteuser[0-9]+/", $_GET["action"]) ? true : false:
                    $id = str_replace("deleteuser", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->adminBoardController->deleteAccount($id);
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                case preg_match("/blockuser[0-9]+/", $_GET["action"]) ? true : false:
                    $id = str_replace("blockuser", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->adminBoardController->blockUser($id);
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                case preg_match("/unblockuser[0-9]+/", $_GET["action"]) ? true : false:
                    $id = str_replace("unblockuser", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->adminBoardController->unblockUser($id);
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                default:
                  
                    break;
            }
        } 
        else 
        {
            if(isset($_GLOBALS['is_connected']) == false)
            {
                $GLOBALS['is_connected'] = false;
            }
            if($GLOBALS['is_connected'] == true)
            {
                $this->feedController->render();
            }
            else 
            {
                $this->formController->render();
            }
        }

    }


}
?>