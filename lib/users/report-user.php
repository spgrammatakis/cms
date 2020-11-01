<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\UserManager();
if (    (!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name']))
    ||  (!isset($_COOKIE["session_token"]) || empty($_COOKIE['session_token']))
    ||  (!isset($_GET['user_id']) || empty($_GET['user_id']))
    )
    {
    http_response_code(403);
    exit;
}else{
    echo "axne";
    $handler = new lib\UserManager();
    $handler->reportUser($_GET['user_id']);
}