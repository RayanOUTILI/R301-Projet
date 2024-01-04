<?php

require_once __DIR__ . "/View.php";
class ProfileView extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../user_profile.php");
    }


   
}

?>