<?php
// Get the PDO DSN string
$root = realpath(__DIR__);
$database = $root . '/data/init.sql';
$dsn = 'mysql:dbname=cms;host:127.0.0.1';
$username = "admin";
$password = "admin";
$error = '';

// A security measure, to avoid anyone resetting the database if it already exists
// if (is_readable($database) && filesize($database) > 0)
// {
//     $error = 'Please delete the existing database manually before installing it afresh';
// }

// Create an empty file for the database
// if (!$error)
// {
//     $createdOk = @touch($database);
//     if (!$createdOk)
//     {
//         $error = sprintf(
//             'Could not create the database, please allow the server to create new files in \'%s\'',
//             dirname($database)
//         );
//     }
// }

// Grab the SQL commands we want to run on the database
if (!$error)
{
    $sql = file_get_contents($database);
    

    if ($sql === false)
    {
        $error = 'Cannot find SQL file';
    }
}

// Connect to the new database and try to run the SQL commands
if (!$error){
try{
	$conn = new PDO($dsn,$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec($sql);
    echo $sql;
    echo "Database created successfully<br>";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
	die();
 }
}
// See how many rows we created, if any
$count = null;
if (!$error)
{
    $sql = "SELECT COUNT(*) AS c FROM post";
    $stmt = $conn->query($sql);
    if ($stmt)
    {
        $count = $stmt->fetchColumn();
    }
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
        <?php if ($error): ?>
            <div class="error box">
                <?php echo $error ?>
            </div>
        <?php else: ?>
            <div class="success box">
                The database and demo data was created OK.
                <?php if ($count): ?>
                    <?php echo $count ?> new rows were created.
                <?php endif ?>
            </div>
        <?php endif ?>
    </body>
</html>