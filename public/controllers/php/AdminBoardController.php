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
        $rien = ["rien"=>"rien"];
        $this->adminBoardView->render($rien);
    }

    public function submitForm()
    {
        if (isset($_POST['admin_user_search'])) 
        {
            $this->cleanFormInput();
            $user_to_search = $_POST['searchbar'];
            $split = explode(" ",$user_to_search);
            $users = array();
            foreach($split as $word)
            {
                $user = $this->getMainDao()->selectFromEquivalent("utilisateurs","$word");
                if(!empty($user) && !in_array($user,$users))
                {
                    array_push($users,$user);
                }
            }
            
            
            if(empty($users))
            {
                $this->renderUserSearch("Aucun utilisateur trouvé");
            }
            else 
            {
                $this->renderUserSearch($users);
            }
            
        }
    }

    public function renderUserSearch($users)
    {
        if($users == "Aucun utilisateur trouvé")
        {
            $this->adminBoardView->renderNoUserFound();
        }
        else 
        {
            $this->adminBoardView->renderUserSearch($users);
        }
    }

    public function blockUser($id)
    {
        
        $this->getMainDao()->block_user($id);
        $this->render();
        header("Location: index.php?action=admin");
    }

    public function unblockUser($id)
    {
        
        $this->getMainDao()->unblock_user($id);
        $this->render();
        header("Location: index.php?action=admin");
    }

    public function deleteAccount($id)
    {
       
        $this->getMainDao()->deleteFrom("utilisateurs","id_utilisateur=$id");
        $this->render();
        header("Location: index.php?action=admin");
    }



}









?>