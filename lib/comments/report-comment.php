<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])){
    exit;
};
if(!isset($_GET['comment_id']) || empty($_GET['comment_id'])){
    exit;
}else{
    $handler = new lib\PostManager();
    $handler->reportComment($_GET['comment_id']);
}