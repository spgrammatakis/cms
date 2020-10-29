<?php

use lib\PostManager;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
if(!isset($_GET['comment_id']) || empty($_GET['comment_id'])){
    echo "NO GET REQUEST FOUND";
}else{
    $handler = new PostManager();
    $handler->reportComment($_GET['comment_id']);
}