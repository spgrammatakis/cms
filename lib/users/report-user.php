<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\UserManager();
if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])){
    exit;
    return;
};
if(!isset($_GET['user_id']) || empty($_GET['user_id'])){
    exit;
}else{
    $handler = new lib\UserManager();
    $handler->reportUser($_GET['user_id']);
}