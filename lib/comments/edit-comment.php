<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if($session->getUserRole() === "guest"){
    http_response_code(403);
    exit;
}

$userManager = new lib\UserManager();
if (isset($_GET['comment_id']))
{
    $commentID = $_GET['comment_id'];
}
else
{
    http_response_code(403);
    exit;
}
$postHandler = new lib\PostManager();
$errors=null;
if($_POST){

    $xsrfToken = hash_hmac('sha256', 'edit-comment.php', $session->getUserID($username));
    if (!(hash_equals($xsrfToken, $_POST['xsrf']))) {
            $xsrf_err = "Invalid Token";
            exit;
        }

    $commentData = array(
        "comment-id" => $commentID,
        "comment-text" => $_POST['comment-text']
    );
   $postHandler->updateComment($commentData);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="default-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/templates/dashboardNavbar/dashboardNavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/dashboard.css" type="text/css">
    </head>
    <body>
<?php require dirname(__DIR__, 2) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
<section class="container">
    <section id ="user-section">
        <?php $postRow = $postHandler->getCommentRow($commentID);?>
            <section class="container">
            <h1 class="comments">Comments</h1>
                <p>Posted by:<?php echo lib\Utilities::htmlEscape($userManager->getUserNameFromID($postRow['user_id'])); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($postRow['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($postRow['created_at']);?></time></p>
            </section>
            <h3>Edit Comment</h3>
        <?php 
        require dirname(__DIR__, 2).'/templates/comment-form.php'; ?>
    </section>
    </body>
</html>