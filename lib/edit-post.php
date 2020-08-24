<?php
require 'common.php';
// Get the post ID
if (isset($_GET['post_id']))
{
    $postId = $_GET['post_id'];
}
else
{
    // So we always have a post ID var defined
    $postId = 0;
}

// Connect to the database, run a query, handle errors
$pdo = new Connection();
$row = $pdo->getPostRow($postId);

if (!$row)
{
    redirectAndExit('index.php?not-found=1');
}

$errors=null;
if($_POST){
    $postTitle=$_POST['post-title'];
    $postBody=$_POST['post-body'];
    $errors=$pdo->updatePost($postId,$postTitle,$postBody);
    print_r($errors);
    if (!$errors)
    {
        redirectAndExit('../view-post.php?post_id=' . $postId);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
    
    <script type="text/javascript" src="../js/get-parent-id.js"></script>
    <script type="text/javascript" src="../templates/text-editor/text-editor.js"></script>
    <h2>
        <title>
            A blog application |
            <?php echo $pdo->htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </h2>
    </head>
    <body>
    <a href="../index.php"><h1>Homepage</h1></a>
    <?php echo "<div class='post' id='" . $postId."'>"; ?>
    <p>
        <div id="post-title">
            <?php echo $pdo->htmlEscape($row['title']) ?>
        </div>
        <div id="post-body">
        <?php echo $pdo->htmlEscape($row['body']);?>
        </div>
        <div>
            <?php echo $pdo->convertSqlDate($row['created_at']) ?>
        </div>
        <div id="post-editor-wrapper">
        <hr style='border: 5px solid red;'>
        <?php require '../templates/post-edit-form.php' ?>
        </div>
        </p>
    </body>
</html>