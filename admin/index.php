<?php

use lib\SessionManager;
use lib\UserManager;

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
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
<?php
require dirname(__DIR__, 1) . '/templates/sidenavbar/sidenavbar.html'; ?>
<div class="content">
<section id ="user-table">
<?php $userManager = new lib\UserManager();
$row = $userManager->getAllUsers();
for($i = 0, $size = count($row); $i < $size; ++$i):
?>
<table id="<?php echo $i; ?>" class="user-table">
    <tr>
        <th>UserName</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Modification Time</th>
        <th>Is Enabled</th>
    </tr>
    <tr>
        <td class="username"><?php echo lib\Utilities::htmlEscape($row[$i]['username']);?></td>
        <td class="email"><?php echo lib\Utilities::htmlEscape($row[$i]['email']);?></td> 
        <td class="created-at"><?php echo lib\Utilities::htmlEscape($row[$i]['created_at']);?></td>  
        <td class="modificiation-time"><?php echo lib\Utilities::htmlEscape($row[$i]['modification_time']);?></td> 
        <td class="is-enabled"><?php echo lib\Utilities::htmlEscape($row[$i]['is_enabled']);?></td>
    </tr>
    <tr>
        <td class="button"><button class="user-table-edit-button">Edit User</button></td>
    </tr>
</table>
<?php endfor; ?>
</section>
<section id="post-section">
<article>  
<?php
$postHandler = new lib\PostManager();
$row = $postHandler->getPosts(3);
for($p = 0; $p < count($row); ++$p):
?>
<header>
    <h1 class="post-title"><?php echo lib\Utilities::htmlEscape($row[$p]['title']);?></h1>
    <p class="post-body"><?php echo lib\Utilities::htmlEscape($row[$p]['body']); ?></p>
    <p><time class="post-date"><?php echo lib\Utilities::convertSqlDate($row[$p]['created_at']); ?></time><p>
</header>
<section>
    <h1 class="comments">Comments</h1>
    <footer>
        <?php
        $comment = $postHandler->getCommentsForPost($row[$p]['post_id']);
        for($c = 0; $c < count($comment); ++$c):
        ?>
        <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($comment[$c]['user_name']); ?></span></p>
        <p><?php echo lib\Utilities::htmlEscape($comment[$c]['content']); ?></p>
        <p><time><?php echo lib\Utilities::htmlEscape($comment[$c]['created_at']);?></time></p>
        <p><?php echo lib\Utilities::htmlEscape($comment[$c]['website']); ?></p>
        <p><?php echo $postHandler->countCommentsForPost($row[$p]['post_id']). " comments"; ?></p>
        <?php endfor; ?>
        <p><?php echo "<a href='/view-post.php?post_id=". lib\Utilities::htmlEscape($row[$p]['post_id']) ."'>Read more...</a>";?></p>
    </footer>
    <p><?php echo "<a href='posts.php'>Show all Posts</a>";?></p>    
</section>
<?php endfor; ?>
</article>
</section>
<section id="comment-section">
<?php $postHandler->prepareStmt("SELECT * FROM comments"); 
    print_r($postHandler->All());?>
</section>
</div>
<footer id="page-bottom">
    footer
</footer>
    </body>
</html>