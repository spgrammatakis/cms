<?php

use lib\PostManager;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
if(!isset($_GET['comment_id']) || empty($_GET['comment_id'])){
    echo "NO GET REQUEST FOUND";
    //header('Location: /index.php');
}else{
    $handler = new PostManager();
    print_r($_GET);
    $row = $handler->reportComment($_GET['id']);
}