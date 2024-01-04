<?php

require_once __DIR__ . "/View.php";

class PostView extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../post.php");
    }
}


?>