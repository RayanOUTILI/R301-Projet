<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/FriendsView.php";

class FriendsController extends Controller
{
    private $FriendsView;
    public function __construct()
    {
        parent::__construct();
        $this->FriendsView = new FriendsView();
    }

    public function render()
    {
        session_start();

        $variables = [
            "friends_request" => $this->_mainDao->getFriendsRequest($_SESSION['adresse_email'])
        ];

        $this->FriendsView->render($variables);


    }

    public function friendRequest(){
        session_start();

        if (isset($_POST['accept'])) {
            // echo "<script>console.log('accept')</script>";
            $this->_mainDao->acceptFriendsRequest($this->_mainDao->getIdFromMail($_SESSION['adresse_email']), $_POST['username']);
        } else if (isset($_POST['decline'])) {
            // echo "<script>console.log('decline')</script>";
            $this->_mainDao->declineFriendsRequest($this->_mainDao->getIdFromMail($_SESSION['adresse_email']), $_POST['username']);
        }

        $variables = [
            "friends_request" => $this->_mainDao->getFriendsRequest($_SESSION['adresse_email'])
        ];

        $this->FriendsView->render($variables);

        // echo "<script>console.log('friendRequest() called')</script>";




    }

}

?>