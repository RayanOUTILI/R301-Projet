<?php

require_once __DIR__ . "/View.php";
class Comment extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../comment.php");
    }



}

?>