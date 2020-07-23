<?php
require './lib/functions.php';
$error = "";
if (isset($_POST['username']) and isset($_POST['username']) ){

  $username = $_POST['username'];
  $password = $_POST['password'];

   if ( is_string($username) == true){
    try{ // Check connection before executing the SQL query 
      /**
       * Setup the connection to the database This is usually called a database handle (dbh)
       */
      $dbh = getPDO();
      
      /**
       * Use PDO::ERRMODE_EXCEPTION, to capture errors and write them to
       * a log file for later inspection instead of printing them to the screen.
       */
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      /**
       * Before executing, prepare statements by binding parameters.
       * Bind validated user input (in this case, the value of $id) to the
       * SQL statement before sending it to the database server.
       *
       */
      $q = "INSERT INTO users(username, password)
            VALUES(:username,:password)";
      // Prepare the SQL query string.
      $stmt = $dbh->prepare($q);
      // Execute statement and Bind parameteres.
      $result = $stmt->execute(
        array(
            'username' => $username,
            'password' => $password 
        )
    );
      $dbh = null;
    }
    catch(PDOException $e){
      /**
       * You can log PDO exceptions to PHP's system logger, using the
       * log engine of the operating system
       *
       * For more logging options visit http://php.net/manual/en/function.error-log.php
       */
      error_log('PDOException - ' . $e->getMessage(), 0);
      /**
       * Stop executing, return an Internal Server Error HTTP status code (500),
       * and display an error
       */
      http_response_code(500);
    }
   } else{
    /**
     * If the value of the 'id' GET parameter is not numeric, stop executing, return
     * a 'Bad request' HTTP status code (400), and display an error
     */
    http_response_code(400);
   }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application | Login
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require 'templates/title.php' ?>
        <p>Register:</p>
        <form method="post">
            <p>
                Username:
                <input type="text" name="username" />
            </p>
            <p>
                Password:
                <input type="password" name="password" />
            </p>
            <input type="submit" name="submit" value="Login" />
        </form>
    </body>
</html>