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
$pdo = new lib\PostManager();
$errors=null;
if($_POST){
    $commentData = array(
        "comment-id" => $commentID,
        "comment-text" => $_POST['comment-text']
    );
    $errors=$pdo->updateComment($commentData);
    if (!$errors)
    {
        header('Location: ' . $_SERVER['PHP_SELF'] . "?comment_id=" . $commentID);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/templates/dashboardNavbar/dashboardNavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/dashboard.css" type="text/css">
    </head>
    <body>
<?php require dirname(__DIR__, 2) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
<section class="container">
    <section id ="user-section">
        <?php $comment = new lib\PostManager();
        $row = $comment->getCommentRow($commentID);
        ?>
            <section class="container">
            <h1 class="comments">Comments</h1>
                <p>Posted by:<?php echo lib\Utilities::htmlEscape($userManager->getUserNameFromID($row['user_id'])); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($row['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($row['created_at']);?></time></p>
            </section>
            <h3>Edit Comment</h3>
        <?php 
        require dirname(__DIR__, 2).'/templates/comment-form.php'; ?>
    </section>
    </body>
</html>