<?php

class OtherProfileView extends View
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../other_profile.php");
    }

    public function renderProfile($user, $publications, $photo_profil, $nb_user_publications, $nb_user_friends, $is_friend)
    {
        $variables = [
            "user" => $user,
            "photo_profil" => $photo_profil,
            "nb_user_publications" => $nb_user_publications,
            "nb_user_friends" => $nb_user_friends,
            "user_publications" => $publications,
            "is_friend" => $is_friend
        ];
        $nom = $user["nom"];
        $prenom = $user["prenom"];
        include_once(__DIR__ . "/../headers/profileheader.php");
        $this->render($variables);        

      
        

    }

}








?>