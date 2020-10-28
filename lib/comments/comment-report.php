<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$handler = new lib\PostManager();
if(!isset($_GET['comment_id']) || empty($_GET['comment_id'])){
    echo "axne";
    //header('Location: /index.php');
}