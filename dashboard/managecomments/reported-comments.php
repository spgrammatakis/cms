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
        <script type="text/javascript" src="/dashboard/dashboard.js" defer></script>
        <link rel="stylesheet" type="text/css" href="/templates/dashboardNavbar/dashboardNavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="/dashboard/dashboard.css" type="text/css">
    </head>
    <body>
<?php require dirname(__DIR__, 2) . '/templates/dashboardNavbar/dashboardNavbar.html'; ?>
<?php
        $postHandler = new lib\PostManager();
        $userHandler = new lib\UserManager();
        $comment = $postHandler->getReportedComments();
        if(count($comment) === 0){
            echo "No Reported Comments";
            exit;
        }
        for($c = 0; $c  < count($comment); ++$c):
        ?>
<div class="container">
        <section>
            <h1 class="comments">Reported Comments</h1>
                <p>Posted by: <span><?php echo lib\Utilities::htmlEscape($userHandler->getUserNameFromID($comment[$c]['user_id']));; ?></span></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['content']); ?></p>
                <p><time><?php echo lib\Utilities::htmlEscape($comment[$c]['created_at']);?></time></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['website']); ?></p>
                <p><?php echo lib\Utilities::htmlEscape($comment[$c]['comment_id']); ?></p>
        <?php endfor; ?>
        </section>
</div>
    </body>
</html>