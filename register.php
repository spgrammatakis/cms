<?php
require __DIR__ . '/vendor/autoload.php';
$userHandler = new lib\UserManager();
$username = $_COOKIE['user_name'] ?? "guest";
$postUsername = $postPassword = $confirmPassword = $postEmail ="";
$usernameError = $passwordError = $confirmPasswordError = $emailError ="";
$xsrfError = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $xsrfToken = hash_hmac('sha256', basename($_SERVER['PHP_SELF']), $userHandler->getUserIDFromName($username));
    if (!(hash_equals($xsrfToken, $_POST['xsrf']))) {
        $xsrfError = "Invalid Token";
        exit;
    }
    
    if(empty(trim($_POST["username"])) || !isset($_COOKIE["user_name"])){
        $usernameError = "Please enter a username.";
    }else{      
        if($userHandler->userNameCheckIfAlreadyExists(trim($_POST["username"]))){
                    $usernameError = "This username is already taken.";
                } else{
                    $postUsername = trim($_POST["username"]);
                }

    }

    if(empty(trim($_POST["email"]))){
        $emailError = "Please enter an email.";
        } else{
            if(($userHandler->userEmailCheckIfAlreadyExists(trim($_POST["email"]))) &&
                (filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL))){
                        $emailError = "This email is already taken.";
                    } else{
                        $postEmail = trim($_POST["email"]);
                    }
         }
    if(empty(trim($_POST['password']))){
        $passwordError = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 5){
        $passwordError = "Password must have atleast 5 characters.";
    } else{
        $postPassword = trim($_POST['password']);
    }
    

    if(empty(trim($_POST["confirm_password"]))){
        $confirmPasswordError = 'Please confirm password.';     
    } else{
        $confirmPassword = trim($_POST['confirm_password']);
        if($postPassword != $confirmPassword){
            $confirmPasswordError = 'Password did not match.';
        }
    }


    if( empty($usernameError)            && 
        empty($passwordError)            && 
        empty($confirmPasswordError)    && 
        empty($emailError)               &&
        empty($xsrfError) ){
        
        $sql = "INSERT INTO users (user_id,username, password, email) VALUES (:user_id,:username, :password, :email)";
        $userHandler->prepareStmt($sql);
            $param_password = password_hash($postPassword, PASSWORD_DEFAULT);
            $userHandler->bind(':user_id',bin2hex(random_bytes(10)));
            $userHandler->bind(':username', $postUsername);
            $userHandler->bind(':password', $param_password);
            $userHandler->bind(':email', $postEmail);
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
                    <span class="help-block"><?php echo $usernameError; ?></span>
                </section>
                <section class="form-email">
                    <label>E-mail</label>
                    <input type="email" name="email"  placeholder="Enter email">
                    <span class="help-block"><?php echo $emailError; ?></span>
                </section>                
                <section class="form-pass">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter Password">
                    <span class="help-block"><?php echo $passwordError; ?></span>
                </section>
                <section class="form-confirm">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                    <span class="help-block"><?php echo $confirmPasswordError; ?></span>
                </section>
                <section class="form-xsrf">
                <input type='hidden' name='xsrf' value="<?php echo hash_hmac('sha256', 'register.php', $userHandler->getUserIDFromName($username));?>"/>
                <span class="help-block"><?php echo $xsrfError; ?></span>
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