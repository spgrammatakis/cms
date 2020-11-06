<?php
require __DIR__ . '/vendor/autoload.php';
ini_set('display_errors', '1');
$pdo = new lib\UserManager();

$username = $password = $confirm_password = $email ="";
$username_err = $password_err = $confirm_password_err = $email_err  ="";

$db = $pdo->getDatabase();
$sql = file_get_contents($db);
$pdo->prepareStmt($sql);
$pdo->run();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"])) || !isset($_COOKIE["user_name"])){
        $username_err = "Please enter a username.";
    }else{      
        if($pdo->userNameCheckIfAlreadyExists(trim($_POST["username"]))){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }

    }

    if(empty(trim($_POST["email"]))){
        if (filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter an email.";
            }
        } else{
            if($pdo->userEmailCheckIfAlreadyExists(trim($_POST["email"]))){
                        $email_err = "This email is already taken.";
                    } else{
                        $email = trim($_POST["email"]);
                    }
         }
    

    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 5){
        $password_err = "Password must have atleast 5 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }
    

    if( empty($username_err) && 
        empty($password_err) && 
        empty($confirm_password_err) && 
        empty($email_err)){  
        $sql = "INSERT INTO users (user_id,username, password, email) VALUES (:user_id,:username, :password, :email)";
        $pdo->prepareStmt($sql);
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_id = bin2hex(random_bytes(10));
        $pdo->bind(':user_id', bin2hex(random_bytes(10)));
        $pdo->bind(':username', $username);
        $pdo->bind(':password', $param_password);
        $pdo->bind(':email', $email);
            if($pdo->run()){
                $session = new lib\SessionManager($username);
                $session->setUserID(bin2hex(random_bytes(10)));
                $session->setUserRole("admin");
                $session->sessionInsertNewRow($session->getUserID());
                //header('Location: index.php');
            } else{
                echo "Something went wrong. Please try again later.";
            } 
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="/lib/includes/style.css">
    <link rel="stylesheet" type="text/css" href="/templates/navbar/navbar.css" type="text/css">
</head>
<body>
    
    <?php 
    require 'templates/navbar/navbar.html'; 
    ?>
    <section class="form-area">
        <section class="form">
            <p>Please fill this form to create an admin account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <section class="form-user">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Type Username">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </section>
                <section class="form-email">
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="Enter email">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </section>                
                <section class="form-pass">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter Password">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </section>
                <section class="form-confirm">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </section>
                <section class="form-submit">
                    <input type="submit" value="Submit">
                    <input type="reset"  value="Reset">
                </section>
                <section>
                </section>
            </form>
        </section>
    </section>
<?php
            $sql = "SELECT COUNT(post_id) FROM posts WHERE reported=0";
            $pdo->prepareStmt($sql);
            $postCount = $pdo->fetchCollumn();
            if($postCount[0] > 0) {echo "New Posts Created" . $postCount[0] . "</br>";}
            
            
            $sql = "SELECT COUNT(comment_id) FROM comments WHERE reported=0";
            $pdo->prepareStmt($sql);
            $commentCount = $pdo->fetchCollumn();
            if($commentCount[0] > 0) {echo "New Comments Created" . $commentCount[0] . "</br>";}
            
            
            $sql = "SELECT COUNT(user_id) FROM users WHERE reported=0";
            $pdo->prepareStmt($sql);
            $userCount = $pdo->fetchCollumn();
            if($userCount[0] > 0) {echo "New User Created : " . $userCount[0] . "</br>";}
              
?>
</body>
</html>