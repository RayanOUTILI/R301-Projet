<?php

require_once __DIR__ . "/View.php";
class FormView extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../form.php");
    }
}



?>