<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/SearchView.php";


class SearchController extends Controller
{
    private $searchView;
    public function __construct()
    {
        parent::__construct();
        $this->searchView = new SearchView();
    }

    public function render()
    {
        session_start();


    }

}

?>