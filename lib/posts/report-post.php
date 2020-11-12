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
    $xsrfToken = hash_hmac('sha256', basename($_SERVER['PHP_SELF']), $session->getUserID($username));
    if (!(hash_equals($xsrfToken, $_GET['xsrf']))) {
            http_response_code(403);
            exit;
        }
    $handler = new lib\PostManager();
    $handler->reportPost($_GET['post_id']);
}