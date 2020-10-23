<?php
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
        <meta http-equiv="Content-Security-Policy" content="script-src 'none' ;" >
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/templates/sidenavbar/sidenavbar.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="admin.css" type="text/css">
        <!-- <meta http-equiv="refresh" content="5"> -->
    </head>
    <body>
<div class="content">
<?php
require dirname(__DIR__, 1) . '/templates/sidenavbar/sidenavbar.html';
$userManager = new lib\UserManager();
$row = $userManager->getAllUsers();
?>
<div class="user-table-block">
<?php foreach($row as $row):?>
    <div class="user-table-block">
        <div class="user-table-block-left">
            <div class="username  user-table-row">
                <div class="user-table-cell">Username</div>
                <div class='user-table-cell'><?php echo lib\Utilities::htmlEscape($row['username']);?></div>
            </div>
            <div class="email  user-table-row">
                <div class='user-table-cell'>Email</div>
                <div class='user-table-cell'><?php echo lib\Utilities::htmlEscape($row['email']);?></div> 
            </div>
            <div class="created-at  user-table-row">
                <div class="user-table-cell">Created at</div>
                <div class="user-table-cell"><?php echo lib\Utilities::htmlEscape($row['created_at']);?></div>  
            </div>
            <div class="modification-time  user-table-row">
                <div class="user-table-cell">Modification Time</div>
                <div class="user-table-cell"><?php echo lib\Utilities::htmlEscape($row['modification_time']);?></div> 
            </div>
            <div class="is-enabled  user-table-row">
                <div class="user-table-cell">Is Enabled</div>
                <div class="user-table-cell"><?php echo lib\Utilities::htmlEscape($row['is_enabled']);?></div> 
            </div>
        </div>
        <div class="user-table-block-right">AXNE</div>
        <div class="user-table-block-button">
            <button class="user-edit-button">Edit User</button>
        </div>
</div>
<?php endforeach; ?>
</div>
</div>
<footer>
    footer
</footer>
    </body>
</html>