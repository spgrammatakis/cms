<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
if( (!isset($_GET['user_id']) 
    || empty($_GET['user_id']))
    || $session->getUserRole() === "guest"){
    http_response_code(403);
    exit;
}
$userHandler = new lib\UserManager();
$row = $userHandler->getUserRow(trim($_GET['user_id']));
if (!$row)
{
    http_response_code(404);
    exit;
}
$userPrivileges = $session->getUserPrivileges($session->getUserRole());
$userPrivileges = json_decode($userPrivileges['user_privileges'], true);
if( (($session->getUserName() !== $row['username']) && ($userPrivileges['edit_self'] === 1))
    || ($userPrivileges['edit_user']=== 1) ){
}else{
    http_response_code(403);
    exit;
}
if($_POST){
    $userData = array(
        "user_id" => $row['user-id'],
        "current-username" => $row['username'],
        "new-username" => trim($_POST['username']),
        "password" => password_hash($_POST['new-password'], PASSWORD_DEFAULT),
        "current-password"=>trim($_POST['current-password']),
        "email" => trim($_POST['email'])
    );
    if($userData['current-username'] !== $userData['new-username']){
        $userHandler->updateUserAndMetadata($userData);
    }
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
<section class="container">
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
</table>
<p><?php echo "<a href='/lib/users/edit-user.php?user_id=". lib\Utilities::htmlEscape($row[$i]['user_id']) ."'>Edit user</a>";?></p>
<?php endfor; ?>
</section>
<?php require dirname(__DIR__, 2).'/templates/user-edit-form.php'; ?>
</section>
    </body>
</html>