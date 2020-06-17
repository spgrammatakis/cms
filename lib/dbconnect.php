<?php 
$dsn = 'mysql:dbname=cms;host:127.0.0.1';
$username = "admin";
$password = "admin";

try{
	$conn = new PDO($dsn,$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
	die();
 }
?>