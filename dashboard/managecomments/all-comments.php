<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if(!($session->getUserRole() === "admin")){
    http_response_code(403);
    exit;
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
<div class="container">
        <header>
        <h1 class="comments">Comments</h1>
        </header>
        <section>
            <footer>
                <?php
                $postHandler = new lib\PostManager();
                $userHandler = new lib\UserManager();
                $commentRow = $postHandler->getAllComments();
                for($c = 0; $c < count($commentRow); ++$c):
                ?>
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($userHandler->getUserNameFromID($commentRow[$c]['user_id'])); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($commentRow[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($commentRow[$c]['created_at']);?></time></p>
                <p><?php echo "<a href='/lib/comment/edit-comment.php?comment_id=". lib\Utilities::htmlEscape($commentRow[$c]['comment_id']) ."'>Edit comment</a>";?></p>
                <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($commentRow[$c]['post_id']) ."'>Go To Post</a>";?></p>
                <?php endfor; ?>
            </footer>
        </section>
</div>
    </body>
</html>