<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])){
    exit;
    return;
};
if(!isset($_GET['post_id']) || empty($_GET['post_id'])){
    exit;
}else{
    
    $handler = new lib\PostManager();
    $handler->reportPost($_GET['post_id']);
}