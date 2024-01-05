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

        $this->FriendsView->render();



    }

}

?>