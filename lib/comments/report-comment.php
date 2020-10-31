<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
if (    (!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name']))
    ||  (!isset($_COOKIE["session_token"]) || empty($_COOKIE['session_token']))
    ||  (!isset($_GET['comment_id']) || empty($_GET['comment_id']))
    )
    {
    http_response_code(403);
    exit;
}else{
    $handler = new lib\PostManager();
    $handler->reportComment($_GET['comment_id']);
}