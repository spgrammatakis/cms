<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if($session->getUserRole() === "guest"){
    http_response_code(403);
    exit;
}else{
    $handler = new lib\PostManager();
    $handler->reportComment($_GET['comment_id']);
}