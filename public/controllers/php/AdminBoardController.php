<?php

require_once __DIR__ . "/Controller.php";
require_once __DIR__ . "/../../views/php/classes/AdminBoardView.php";

class AdminBoardController extends Controller
{
    private $adminBoardView;
    public function __construct()
    {
        parent::__construct();
        $this->adminBoardView = new AdminBoardView();
    }

    public function render()
    {
        $this->adminBoardView->render();
    }

    public function submitForm()
    {
        if (isset($_POST['admin_user_search'])) 
        {
            $this->cleanFormInput();
            $user_to_search = $_POST['searchbar'];

            $user_info = $this->getMainDao()->selectFromEquivalent("utilisateurs","nom,prenom,date_naissance,adresse,telephone_portable,adresse_email_secours,photo_profil,id_utilisateur","adresse_email = '$user_to_search'");
            

            
        }
    }



}









?>