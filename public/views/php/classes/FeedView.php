<?php

require_once __DIR__ . "/View.php";
class FeedView extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../feed.php");
    }



}

?>