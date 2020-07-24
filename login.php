<?php
require_once 'lib/common.php';
// We need to test for a minimum version of PHP, because earlier versions have bugs that affect security
if (version_compare(PHP_VERSION, '5.3.7') < 0)
{
    throw new Exception(
        'This system needs PHP 5.3.7 or later'
    );
}
    $dbh = getPDO();
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{        
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = :username";
        
        if($stmt = $dbh->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            
            // Set parameters
           // $test = trim($_POST["username"]);
            $param_username =trim($_POST["username"]);
            // Attempt to execute the prepared statement
            if($stmt->execute()){                
                    // Check if username exists, if yes then verify password
                    if($stmt->rowCount() == 1){
                            if($row = $stmt->fetch()){
                                $hashed_password = $row['password'];
                                if(password_verify($password, $hashed_password)){
                                    /* Password is correct, so start a new session and
                                    save the username to the session */
                                    session_start();
                                    $_SESSION['username'] = $username;
                                        if($param_username == admin){
                                            $_SESSION['user_role'] = 'admin';
                                            header("location:/admin/admin.php");							
                                        }
                                            else{
                                                $_SESSION['user_role'] = 'user';
                                                header("location: welcome.php");
                                            }

                                } else{
                                    // Display an error message if password is not valid
                                    $password_err = 'The password you entered was not valid.';
                                }
                            }
                    } else{
                        // Display an error message if username doesn't exist
                        $username_err = 'No account found with that username.';
                    }   
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Login</title>
	<link rel="stylesheet" type="text/css" href="./includes/register.css">
</head>
<body>
    <div class="form-area">
        <div class="form">
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="username">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>"  placeholder="Enter password">
                    <span class=""><?php echo $username_err; ?></span>
                </div>    
                <div class="password">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password">
                    <span class=""><?php echo $password_err; ?></span>
                </div>
                <div class="submit">
                    <input type="submit" class="submit-btn btn" value="Login">
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </form>
        </div>
    </div>    
</body>
</html>