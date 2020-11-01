<?php
require __DIR__ . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
        <script type="text/javascript" src="/js/report-post-comment-user.js" defer></script>
        <link rel="stylesheet" type="text/css" href="/lib/includes/style.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/templates/navbar/navbar.css" type="text/css">
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>  
        <?php
        require 'templates/navbar/navbar.html';
        $postHandler = new lib\PostManager();
        $userHandler = new lib\UserManager();
        $row = $postHandler->getPosts();
        ?>
<div class="container">
<?php for($p = 0; $p  < count($row); ++$p): ?>
    <section class="post" id="<?php echo lib\Utilities::htmlEscape($row[$p]['post_id']);?>">
    <article>
        <header>
            <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($row[$p]['title']);?></h1>
            <p class="post-body"><?php echo lib\Utilities::htmlEscape($row[$p]['body']); ?></p>
            <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($row[$p]['created_at']); ?></time><p>
            <p><button class='post-report-button'>Report Post</button></p>
        </header>
        <?php
                $comment = $postHandler->getCommentsForPost($row[$p]['post_id']);
                for($c = 0; $c < count($comment); ++$c):
                ?>
        <?php echo "<section class='comment' id='" . $comment[$c]['comment_id']."'>"; ?>
        <h1 class="comments">Comments</h1>  
            <footer class="user" id="<?php echo $comment[$c]['user_id'];?>">
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($userHandler->getUserNameFromID($comment[$c]['user_id'])); ?></span>
                <span><button class='user-report-button'>Report User</button></span></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($comment[$c]['created_at']);?></time></p>
                <p><button class='comment-report-button'>Report Comment</button></p>
                <?php endfor; ?>
            </footer>
        </section>
        <section>
        <p><?php echo $postHandler->countCommentsForPost($row[$p]['post_id']). " comments"; ?></p>
        <p><?php echo "<a href='/lib/posts/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$p]['post_id']) ."'>Read more...</a>";?></p>
        </section>
    </article>
    </section>
    <?php endfor; ?>
</div>
    </body>
</html>