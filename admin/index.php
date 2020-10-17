<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if(!($session->getUserRole() === "admin")){
    header("HTTP/1.1 403 Not Found");
    echo "axne";
    exit;
}
?>