<?php
require __DIR__ . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'none' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
        <?php
        require 'templates/title.php';
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
                for($c = 0, $size = count($comment); $c < $size; ++$c):
                ?>
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($comment[$c]['user_name']); ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($comment[$c]['created_at']);?></time></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['website']); ?></p>
                <p><?php echo $postHandler->countCommentsForPost($row[$i]['post_id']). " comments"; ?></p>
                <?php endfor; ?>
            </footer>
        </section>
        <section>
        <p><?php echo "<a href='/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$i]['post_id']) ."'>Read more...</a>";?></p>
        </section>
    </article>
</div>
        <?php endfor; ?>
        <a href="./setup.php">Setup</a>        
    </body>
</html>