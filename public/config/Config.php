<?php 
require_once __DIR__ . "/../router/Router.php";
class Config
{
    const DBHOST = "linserv-info-01.campus.unice.fr";
    const DBNAME = "or201305_R301-Projet";
    const DBUSERNAME = "or201305";
    const DBPASSWORD = "s]3zY[KhQ54(*qC0";
}
$router = new Router();
setcookie("router", serialize($router), time() + 3600, "/");
?>