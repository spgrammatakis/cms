<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if($session->getUserRole() === "guest"){
    http_response_code(403);
    exit;
}

$pdo = new lib\PostManager();
$userHandler = new lib\UserManager();
$errors=null;
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $xsrfToken = hash_hmac('sha256', __FILE__, $session->getUserID($username));
    if (!(hash_equals($xsrfToken, $_POST['xsrf']))) {
            $xsrf_err = "Invalid Token";
        }

    $postData = array(
        "post-id" => bin2hex(random_bytes(10)),
        "post-title" => trim($_POST['post-title']),
        "post-body" => trim($_POST['post-body']),
        "author-id" => $userHandler->getUserIDFromName($username)
    );
    $pdo->addPost($postData);

}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
    <script type="text/javascript" src="/js/redirect-to-edit.js"></script>
    <link rel="stylesheet" type="text/css" href="/lib/includes/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="/templates/navbar/navbar.css" type="text/css">
        <title>
            A blog application |
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require dirname(__DIR__, 2) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
<section class="form-area">
    <h3>New Post</h3>
    <section class="form">
    <?php require dirname(__DIR__, 2).'/templates/post-add-form.php'; ?>
    </section>
</section>
    </body>
</html>