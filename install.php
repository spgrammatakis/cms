<?php
// Get the PDO DSN string
$root = realpath(__DIR__);
$database = $root . '/data/init.sql';
$dsn = 'mysql:dbname=cms;host:127.0.0.1';
$username = "admin";
$password = "admin";

$sql = file_get_contents($database);
// Connect to the new database and try to run the SQL commands
try{
	$conn = new PDO($dsn,$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec($sql);
    echo "Database created successfully<br>";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
	die();
 }
// See how many rows we created, if any
$count = 0;
    $sql = "SELECT * FROM posts";
    $stmt = $conn->query($sql);
    if ($stmt)
    {
        $count = $stmt->fetchColumn();
        echo "New posts created: " . $count . "<br>";
    }
    $sql = "SELECT * FROM comments";
    $stmt = $conn->query($sql);
    if ($stmt)
    {
        $count = $stmt->fetchColumn();
        echo "New posts created: " , $count;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <style type="text/css">
            .box {
                border: 1px dotted silver;
                border-radius: 5px;
                padding: 4px;
            }
            .error {
                background-color: #ff6666;
            }
            .success {
                background-color: #88ff88;
            }
        </style>
    </head>
    <body>
            <div class="success box">
                The database and demo data was created OK.
                <?php if ($count): ?>
                    <?php echo $count ?> new rows were created.
                <?php endif ?>
            </div>
    </body>
</html>