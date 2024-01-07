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

}

?>