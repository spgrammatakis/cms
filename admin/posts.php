<?php

use lib\PostManager;

require dirname(__DIR__, 1) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if(!($session->getUserRole() === "admin")){
    header("HTTP/1.1 403 Not Found");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <script type="text/javascript" src="admin.js" defer></script>
        <link rel="stylesheet" type="text/css" href="/templates/sidenavbar/sidenavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="admin.css" type="text/css">
    </head>
    <body>
<?php require dirname(__DIR__, 1) . '/templates/sidenavbar/sidenavbar.html'; ?>
<?php
        $postHandler = new lib\PostManager();
        $row = $postHandler->getPosts();
        for($i = 0, $size = count($row); $i < $size; ++$i):
        ?>
<div class="container">
    <article>
        <header>
            <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($row[$i]['title']);?></h1>
            <p class="post-body"><?php echo lib\Utilities::htmlEscape($row[$i]['body']); ?></p>
            <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($row[$i]['created_at']); ?></time><p>
        </header>
        <section>
            <h1 class="comments">Comments</h1>
            <footer>
                <?php
                $comment = $postHandler->getCommentsForPost($row[$i]['post_id']);
                for($i = 0, $size = count($comment); $i < $size; ++$i):
                ?>
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($comment[$i]['user_name']); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$i]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($comment[$i]['created_at']);?></time></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$i]['website']); ?></p>
                <?php endfor; ?>
                <p><?php echo $postHandler->countCommentsForPost($row[$i]['post_id']). " comments"; ?></p>
            </footer>
        </section>
        <section>
        <p><?php echo "<a href='/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$i]['post_id']) ."'>Read more...</a>";?></p>
        </section>
    </article>
</div>
        <?php endfor; ?>
<footer id="page-bottom">
    footer
</footer>
    </body>
</html>