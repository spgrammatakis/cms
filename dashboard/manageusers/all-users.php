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
<section id ="user-section">
<h1 class="users">Users</h1>
<?php $userManager = new lib\UserManager();
$row = $userManager->getAllUsers();
for($i = 0, $size = count($row); $i < $size; ++$i):
?>
<table id="<?php echo $i; ?>" class="user-table">
    <tr>
        <th>UserName</th>
        <th>UserID</th>
        <th>Email</th>
        <th>Created at</th>
        <th>Modification Time</th>
        <th>Reported</th>
    </tr>
    <tr>
        <td class="user-id"><?php echo lib\Utilities::htmlEscape($row[$i]['user_id']);?></td>
        <td class="username"><?php echo lib\Utilities::htmlEscape($row[$i]['username']);?></td>
        <td class="email"><?php echo lib\Utilities::htmlEscape($row[$i]['email']);?></td> 
        <td class="created-at"><?php echo lib\Utilities::htmlEscape($row[$i]['created_at']);?></td>  
        <td class="modificiation-time"><?php echo lib\Utilities::htmlEscape($row[$i]['modification_time']);?></td> 
        <td class="reported"><?php echo lib\Utilities::htmlEscape($row[$i]['reported']);?></td>
    </tr>
    <tr>
        <td class="button"><button class="user-edit-button">Edit User</button></td>
    </tr>
</table>
<?php endfor; ?>
</section>
</div>
    </body>
</html>