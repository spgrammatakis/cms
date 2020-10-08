<?php
include 'lib/includes/autoload.inc.php';
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();
$dbh = new lib\DbConnection();
 

$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{        
        $username = trim($_POST["username"]);
    }
    

    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }

    if(empty($username_err) && empty($password_err)){

        $sql = "SELECT username, password FROM users WHERE username = :username";
        $dbh->prepareStmt($sql);
        $param_username =trim($_POST["username"]);                
        $dbh->bind(':username', $param_username);
            if($dbh->run()){              
                    if($dbh->rowCount() == 1){
                                $row = $dbh->SingleRow();
                                $hashed_password = $row['password'];
                                if(password_verify($password, $hashed_password)){
                                    setcookie("user_name", $row['username'], [
                                        "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
                                        "path" => '/',
                                        "domain" => "",
                                        "secure" => false,
                                        "httponly" => true,
                                        "samesite" => "Strict"]);
                                    $session->redirectUser($session->getUserRole());
                                } else{
                                    
                                    $password_err = 'The password you entered was not valid.';
                                }
                            
                    } else{
                        
                        $username_err = 'No account found with that username.';
                    }   
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

    }

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
