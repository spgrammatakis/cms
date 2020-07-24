<?php
require './lib/common.php';
$dbh = getPDO();
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email ="";
$username_err = $password_err = $confirm_password_err = $email_err  ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = :username";
        
        if($stmt = $dbh->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
        //Validate email
        if(empty(trim($_POST["email"]))){
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter an email.";
            }
        } else{
            // Prepare a select statement
            $sql = "SELECT user_id FROM users WHERE email = :email";
            
            if($stmt = $dbh->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam('email', $param_email, PDO::PARAM_STR);
                
                // Set parameters
                $param_email = trim($_POST["email"]);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $email_err = "This email is already taken.";
                    } else{
                        $email = trim($_POST["email"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
             
            // Close statement
            unset($stmt);
         }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 5){
        $password_err = "Password must have atleast 5 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
         
        if($stmt = $dbh->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = ($username);
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email    = ($email); 
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($dbh);
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
            <h2>Sign Up</h2>
            <p>Please fill this form to create an account.</p>
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
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>        
</body>
</html>