<?php
spl_autoload_register('autoload');

function autoload($className){
    $filename = dirname(__DIR__, 1).'/'.$className.'.php';
    require_once str_replace('\\','/',$filename);
}
//if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) echo "axne";
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
?>