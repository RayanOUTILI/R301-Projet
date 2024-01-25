<?php
require_once __DIR__ . "/../controllers/php/FormController.php";
require_once __DIR__ . "/../controllers/php/PostController.php";
require_once __DIR__ . "/../controllers/php/ProfileController.php";
require_once __DIR__ . "/../controllers/php/FeedController.php";
require_once __DIR__ . "/../controllers/php/AdminBoardController.php";
require_once __DIR__ . "/../controllers/php/FriendsController.php";
require_once __DIR__ . "/../controllers/php/OtherProfileController.php";
require_once __DIR__ . "/../controllers/php/SearchController.php";
require_once __DIR__ . "/../controllers/php/CommentController.php";

class Router
{
    private $formController;
    private $postController;
    private $profileController;
    private $feedController;
    private $adminBoardController;
    private $errorView;
    private $friendsController;
    private $otherProfileController;
    private $searchController;

    private $commentController;


    public function __construct()
    {
        $this->formController = new FormController();
        $this->postController = new PostController();
        $this->profileController = new ProfileController();
        $this->feedController = new FeedController();
        $this->friendsController = new FriendsController();
        $this->adminBoardController = new AdminBoardController();
        $this->otherProfileController = new OtherProfileController();
        $this->searchController = new SearchController();
        $this->commentController = new CommentController();

    }

    public function route()
    {
        if (isset($_GET["action"])) {
            if (isset($GLOBALS["is_connected"]) && $GLOBALS['is_connected'] == false && $_GET["action"] != "form" && $_GET["action"] != "login" && $_GET["action"] != "signup") {
                echo "Vous devez être connecté pour accéder à cette page";
                $this->formController->render();
                return;
            }
            switch ($_GET["action"]) {
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
                case "page":
                    echo "<script>console.log('test')</script>";
                    $this->feedController->render();
                    break;
                case "feed":
                    $this->feedController->render();
                    break;
                case "search-by-time":
                    $this->searchController->searchByTime();
                    break;
                case "search":
                    $this->searchController->render();
                    break;
                case "friends":
                    $this->friendsController->render();
                    break;
                case "friends-request":
                    $this->friendsController->friendRequest();
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
                case "postLiked":
                    session_start();
                    echo '<script>console.log("postLikes")</script>';
                    $this->feedController->PostLiked();
                    break;
                case "postDisliked":
                    session_start();
                    echo '<script>console.log("postDislikes")</script>';
                    $this->feedController->PostDisliked();
                    break;
                case "comment":
                    session_start();
                    $this->commentController->createNewComment();
                    break;
                case "postCommented":
                    session_start();
                    echo '<script>console.log("postCommented")</script>';
                    $postId = $_POST['postId'];
                    echo "<script>console.log('$postId')</script>";
                    $this->commentController->renderId($postId);
                    $this->commentController->render();
                    $this->commentController->displayComments($postId);
                    break;
                case preg_match("/deleteuser[0-9]+/", $_GET["action"]) ? true : false:
                    $id = str_replace("deleteuser", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->adminBoardController->deleteAccount($id);
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                case preg_match("/^blockuser[0-9]+$/", $_GET["action"]) ? true : false:
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
                case preg_match("/^deletepost[0-9]+$/", $_GET["action"]) ? true : false:
                    $id = str_replace("deletepost", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        //$this->adminBoardController->deletePost($id); //TODO
                        echo "template";
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                case preg_match("/^deletecomment[0-9]+$/", $_GET["action"]) ? true : false:
                    $id = str_replace("deletecomment", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        //$this->adminBoardController->deleteComment($id); //TODO
                        echo "template";
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                // si on vuet envoyer un message
                case preg_match("/^sendmessage[0-9]+$/", $_GET["action"]) ? true : false:
                    $id = str_replace("sendmessage", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->adminBoardController->sendMessage($id);
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");
                    break;
                case preg_match("/^profile[0-9]+$/", $_GET["action"]) ? true : false:

                    $id = str_replace("profile", "", $_GET["action"]);
                    session_start();
                    if ($_SESSION['is_admin'] == true)
                        $this->otherProfileController->render($id);
                    else
                        $this->errorView->render("Vous n'avez pas les droits pour accéder à cette page");

                    break;

                case preg_match("/^blockContent[0-9]+$/", $_GET["action"]) ? true : false:
                    $id = str_replace("blockContent", "", $_GET["action"]);
                    $this->adminBoardController->blockContent($id);
                    break;
                default:

                    break;
            }
        } else {
            if (isset($_GLOBALS['is_connected']) == false) {
                $GLOBALS['is_connected'] = false;
            }
            if ($GLOBALS['is_connected'] == true) {
                $this->feedController->render();
            } else {
                $this->formController->render();
            }
        }

    }


}
