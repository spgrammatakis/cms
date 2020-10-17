<?php
require __DIR__ . '/vendor/autoload.php';
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
    Utilities::redirectAndExit('index.php?not-found=1');
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
    
    <script type="text/javascript" src="js/get-parent-id.js"></script>
    <script type="text/javascript" src="js/iframe-interactions.js"></script>
    <h2>
        <title>
            A blog application |
            <?php echo lib\Utilities::htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </h2>
    </head>
    <body>
    <a href="index.php"><h1>Homepage</h1></a>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
    <p>
        <div id="post-title">
            <?php echo lib\Utilities::htmlEscape($row['title']) ?>
        </div>
        <div id="post-body">
        <?php echo lib\Utilities::htmlEscape($row['body']);?>
        </div>
        <div>
            <?php echo lib\Utilities::convertSqlDate($row['created_at']) ?>
        </div>
        <div id="post-editor-wrapper">
        <hr style='border: 5px solid red;'>
        <?php require 'templates/post-edit-form.php' ?>
        </div>
        </p>
    </body>
</html>