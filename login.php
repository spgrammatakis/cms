<?php
require __DIR__ . '/vendor/autoload.php';
$dbh = new lib\DbConnection();
$username = $_COOKIE['user_name'] ?? "guest";
$session = new lib\SessionManager($username);
$session->sessionCheck();

$username = $password = "";
$username_err = $password_err = "";
$xsrf_err="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $xsrfToken = hash_hmac('sha256', basename($_SERVER['PHP_SELF']), $session->getUserID($username));
    if (!(hash_equals($xsrfToken, $_POST['xsrf']))) {
        $xsrf_err = "Invalid Token";
        exit;
    } 

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
                                    setcookie("session_token", bin2hex(random_bytes(20)), [
                                        "expires" => mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1),
                                        "path" => '/',
                                        "domain" => "",
                                        "secure" => false,
                                        "httponly" => true,
                                        "samesite" => "Strict"]);    
                                    $session = new lib\SessionManager($row['username']);
                                    $session->sessionCheck();
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
<?php require 'templates/header/header.html';?>
<body>
<?php require 'templates/navbar/navbar.html'; ?>
<section clas="form-area">
        <section class="form">
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <section class="username">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>"  placeholder="Enter password">
                    <span class=""><?php echo $username_err; ?></span>
                </section>    
                <section class="password">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password">
                    <span class=""><?php echo $password_err; ?></span>
                </section>
                <section class="submit">
                    <input type="submit" class="submit-btn btn" value="Login">
                </section>
                <section>
                <input type='hidden' name='xsrf' value="<?php echo hash_hmac('sha256', 'login.php', $session->getUserID($username));?>"/>
                </section>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </form>
        </section>
</section>   
</body>
</html>
