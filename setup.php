<?php
include 'lib/includes/autoload.inc.php';
require 'install.php';
$pdo = new lib\DbConnection();

$username = $password = $confirm_password = $email ="";
$username_err = $password_err = $confirm_password_err = $email_err  ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{        
        $sql = "SELECT user_id FROM users WHERE username = :username";    
        $pdo->prepareStmt($sql);
        $param_username = trim($_POST["username"]);
        $pdo->bind(':username', $param_username);
            if($pdo->run()){
                if($pdo->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

    }

        if(empty(trim($_POST["email"]))){
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter an email.";
            }
        } else{

            $sql = "SELECT user_id FROM users WHERE email = :email";
            
            $pdo->prepareStmt($sql);
                $param_email = trim($_POST["email"]);
                $pdo->bind('email', $param_email);
                
                if($pdo->run()){
                    if($pdo->rowCount() == 1){
                        $email_err = "This email is already taken.";
                    } else{
                        $email = trim($_POST["email"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
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
    

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $pdo->prepareStmt($sql);
            $param_username = ($username);
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email    = ($email);
            $pdo->bind(':username', $param_username);
            $pdo->bind(':password', $param_password);
            $pdo->bind(':email', $param_email);
            if($pdo->run()){
                $session = new lib\SessionManager($param_username);
                $session->setUserID(1);
                $session->setUserRole("admin");
                $session->sessionInsertNewRow($session->getUserID());
                header('Location: index.php');
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
	<link rel="stylesheet" type="text/css" href="./includes/register.css">
</head>
<body>
    <div class="form-area">
        <div class="form">
            <p>Please fill this form to create an admin account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-user">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Type Username">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-email">
                    <label>E-mail</label>
                    <input type="email" name="email"  value="<?php echo $email ?>" placeholder="Enter email">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>                
                <div class="form-pass">
                    <label>Password</label>
                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Enter Password">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-confirm">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password"  value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-submit">
                    <input type="submit" class="submit-btn btn"  value="Submit">
                    <input type="reset" class="reset-btn btn" value="Reset">
                </div>
            </form>
        </div>
    </div>        
</body>
</html>