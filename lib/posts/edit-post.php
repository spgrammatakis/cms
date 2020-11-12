<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if($session->getUserRole() === "guest"){
    http_response_code(403);
    exit;
}
if (isset($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    http_response_code(403);
    exit;
}

$postHandler = new lib\PostManager();
$postRow = $postHandler->getPostRow($postId);

$errors=null;
if($_POST){
    $xsrfToken = hash_hmac('sha256', basename($_SERVER['PHP_SELF']), $session->getUserID($username));
    if (!(hash_equals($xsrfToken, $_POST['xsrf']))) {
            $xsrf_err = "Invalid Token";
            exit;
        }
    $postTitle=$_POST['post-title'];
    $postBody=$_POST['post-body'];
    $errors=$postHandler->updatePost($postId,$postTitle,$postBody);
    if (!$errors)
    {
        header('Location: ' . $_SERVER['PHP_SELF'] . "?post_id=" . $postId);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' ;" >
    <script type="text/javascript" src="/js/redirect-to-edit.js"></script>
    <link rel="stylesheet" type="text/css" href="/lib/includes/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="/templates/navbar/navbar.css" type="text/css">
        <title>
            <?php echo lib\Utilities::htmlEscape($postRow['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require dirname(__DIR__, 2) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
<div class="container">
    <?php echo "<section class='post' id='" . $postRow['post_id']."'>"; ?>
    <article>
        <header>
            <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($postRow['title']);?></h1>
            <p class="post-body"><?php echo lib\Utilities::htmlEscape($postRow['body']); ?></p>
            <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($postRow['created_at']); ?></time><p>
        </header>
        <section>
        <p><?php echo $postHandler->countCommentsForPost($postRow['post_id']). " comments"; ?></p>
        <p><a href="/lib/posts/view-post.php?post_id=<?php echo  lib\Utilities::htmlEscape($postRow[$p]['post_id']) ?>">Read more ...</a></p>
        </section>
    </article>
    </section>
    <?php require dirname(__DIR__, 2).'/templates/post-edit-form.php'; ?>
</div>
    </body>
</html>