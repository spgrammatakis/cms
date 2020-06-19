<?php

/**
 * Blog installer function
 * 
 * @return array(postCount integer, commentCount integer)
 */
function installBlog()
{
    require 'lib/functions.php';
    require 'lib/dbconnect.php';

    $sql = file_get_contents($database);
    $pdo = getPDO();

// See how many rows we created, if any

    $sql = "SELECT * FROM posts";
    $stmt = $conn->query($sql);
    if ($stmt)
    {
        $postCount = $stmt->fetchColumn();
        echo "New posts created: " . $count . "<br>";
    }
    $sql = "SELECT * FROM comments";
    $stmt = $conn->query($sql);
    if ($stmt)
    {
        $commentCount = $stmt->fetchColumn();
        echo "New posts created: " , $count;
    }
    return array($postCount, $commentCount);
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
                <?php if ($postCount and $commentCount): ?>
                    <?php echo $postCount ?> new posts were created.
                    <?php echo $commentCount ?> new comments were created.
                <?php endif ?>
            </div>
    </body>
</html>