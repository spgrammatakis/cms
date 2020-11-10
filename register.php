<?php
require __DIR__ . '/vendor/autoload.php';
$userHandler = new lib\UserManager();
$user = $_COOKIE['user_name'] ?? "guest";
$username = $password = $confirm_password = $email ="";
$username_err = $password_err = $confirm_password_err = $email_err ="";
$xsrf_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $xsrfToken = hash_hmac('sha256', __FILE__, $userHandler->getUserIDFromName($user));
    if (!(hash_equals($xsrfToken, $_POST['xsrf']))) {
        $xsrf_err = "Invalid Token";
    }
    if(empty(trim($_POST["username"])) || !isset($_COOKIE["user_name"])){
        $username_err = "Please enter a username.";
    }else{      
        if($userHandler->userNameCheckIfAlreadyExists(trim($_POST["username"]))){
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
            if($userHandler->userEmailCheckIfAlreadyExists(trim($_POST["email"]))){
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


    if( empty($username_err)            && 
        empty($password_err)            && 
        empty($confirm_password_err)    && 
        empty($email_err)               &&
        empty($xsrf_err) ){
        
        $sql = "INSERT INTO users (user_id,username, password, email) VALUES (:user_id,:username, :password, :email)";
        $userHandler->prepareStmt($sql);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $userHandler->bind(':user_id',bin2hex(random_bytes(10)));
            $userHandler->bind(':username', $param_username);
            $userHandler->bind(':password', $param_password);
            $userHandler->bind(':email', $email);
            if($userHandler->run()){            
                $session = new lib\SessionManager($param_username);
                $session->setUserRole("guest");
                $sql = "SELECT user_id FROM users WHERE username=:username";
                $userHandler->prepareStmt($sql);
                $userHandler->bind(":username",$param_username);
                $userID = $userHandler->SingleRow();
                $session->setUserID($userID['user_id']);
                $session->sessionInsertNewRow($session->getUserID());
                //header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
    }
    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<?php require 'templates/header/header.html';?>
<?php require 'templates/navbar/navbar.html'; ?>
<body>
        <section id="form-area">
            <h2>Sign Up</h2>
            <p>Create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <section class="form-user">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Type Username">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </section>
                <section class="form-email">
                    <label>E-mail</label>
                    <input type="email" name="email"  placeholder="Enter email">
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
                <section class="form-xsrf">
                <input type='hidden' name='xsrf' value="<?php echo hash_hmac('sha256', __FILE__, $userHandler->getUserIDFromName($user));?>"/>
                <span class="help-block"><?php echo $xsrf_err; ?></span>
                </section>
                <section class="form-submit">
                    <input type="submit" class="submit-btn btn"  value="Submit">
                    <input type="reset" class="reset-btn btn" value="Reset">
                </section>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
            <a href="index.php">Homepage</a>
    </section>
</body>
</html>