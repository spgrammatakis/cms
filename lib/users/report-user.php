<?php

use lib\PostManager;
use lib\UserManager;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])){
    exit;
    return;
};
if(!isset($_GET['user_id']) || empty($_GET['user_id'])){
    exit;
}else{
    $handler = new UserManager();
    $handler->reportUser($_GET['user_id']);
}