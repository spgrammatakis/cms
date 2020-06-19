<?php

/**
 * Blog installer function
 * 
 * @return array(postCount integer, commentCount integer)
 */
function installBlog()
{
    include_once 'lib/functions.php';

    $sql = file_get_contents(getDatabase());
    $pdo = getPDO();
    $pdo->exec($sql);

// See how many rows we created, if any

    $sql = "SELECT * FROM posts";
    $stmt = $pdo->query($sql);
    if ($stmt)
    {
        $postCount = $stmt->rowCount();
        echo "New posts created: " . $postCount . "<br>";
    }
    $sql = "SELECT * FROM comments";
    $stmt = $pdo->query($sql);
    if ($stmt)
    {
        $commentCount = $stmt->rowCount();
        echo "New posts created: " , $commentCount;
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
    <?php ?>
            <div class="success box">
                The database and demo data was created OK.<br>
                <?php installBlog(); ?>
                <?php if (installBlog()[0] and installBlog()[1]): ?>
                    <?php echo installBlog()[0] ?> new posts were created.
                    <?php echo installBlog()[1] ?> new comments were created.
                <?php endif ?>
            </div>
    </body>
</html>