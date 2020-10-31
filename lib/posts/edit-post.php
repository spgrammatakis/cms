<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();

if (isset($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    $postId = 0;
}

$pdo = new lib\PostManager();
$row = $pdo->getPostRow($postId);
if (!$row)
{
    lib\Utilities::redirectAndExit();
}

$errors=null;
if($_POST){
    $postTitle=$_POST['post-title-textarea'];
    $postBody=$_POST['post-body-textarea'];
    echo $postTitle;
    echo $postBody;
    $errors=$pdo->updatePost($postId,$postTitle,$postBody);
    var_dump($errors);
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
    
    <script type="text/javascript" src="/js/redirect-to-edit.js"></script>
    <link rel="stylesheet" type="text/css" href="/lib/includes/style.css" type="text/css">
    <h2>
        <title>
            A blog application |
            <?php 
            
            echo lib\Utilities::htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </h2>
    </head>
    <body>
    <a href="/index.php"><h1>Homepage</h1></a>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
    <p>
        <div id="post-title">
            <?php echo lib\Utilities::htmlEscape($row[0]['title']) ?>
        </div>
        <div id="post-body">
        <?php echo lib\Utilities::htmlEscape($row[0]['body']);?>
        </div>
        <div>
            <?php echo lib\Utilities::convertSqlDate($row[0]['created_at']) ?>
        </div>
        <div id="post-editor-wrapper">
        <hr style='border: 5px solid red;'>
        <?php require dirname(__DIR__, 2).'/templates/post-edit-form.php' ?>
        </div>
        </p>
    </body>
</html>