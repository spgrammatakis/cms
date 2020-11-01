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

$pdo = new lib\PostManager();
$row = $pdo->getPostRow($postId);

$errors=null;
if($_POST){
    $postTitle=$_POST['post-title'];
    $postBody=$_POST['post-body-textarea'];
    $errors=$pdo->updatePost($postId,$postTitle,$postBody);
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
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
    <script type="text/javascript" src="/js/redirect-to-edit.js"></script>
    <link rel="stylesheet" type="text/css" href="/lib/includes/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="/templates/navbar/navbar.css" type="text/css">
    <h2>
        <title>
            A blog application
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </h2>
    </head>
    <body>
    <?php require dirname(__DIR__, 2) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
<div class="container">
    <?php echo "<section class='post' id='" . $row['post_id']."'>"; ?>
    <?php print_r($row);?>
    <article>
        <header>
            <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($row['title']);?></h1>
            <p class="post-body"><?php echo lib\Utilities::htmlEscape($row['body']); ?></p>
            <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($row['created_at']); ?></time><p>
        </header>
        <section>
        <p><?php echo $pdo->countCommentsForPost($row['post_id']). " comments"; ?></p>
        <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($row['post_id']) ."'>Read more...</a>";?></p>
        </section>
    </article>
    </section>
    <?php require dirname(__DIR__, 2).'/templates/post-edit-form.php'; ?>
</div>
    </body>
</html>