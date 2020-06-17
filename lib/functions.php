<?php
function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

function convertSqlDate($sqlDate)
{
    /* @var $date DateTime */
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);
    return $date->format('Y-m-d H:i:s');
}

/**
 * Returns the post row
 *
 * @param pdo $pdo
 * @param integer $postId
 */
function getPostRow(PDO $pdo, $postId){
    $stmt = $pdo->prepare(
        'SELECT
            title, created_at, body
        FROM
            posts
        WHERE
            post_id = :post_id'
    );
    if ($stmt === false)
    {
        throw new Exception('There was a problem preparing this query');
    }
    $result = $stmt->execute(
        array('post_id' => $postId,)
    );
    if ($result === false)
    {
        throw new Exception('There was a problem running this query');    
    }
    
    // Let's get a row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

/**
 * Returns all the comments for the specified post
 *
 * @param integer $postId
 */
function getCommentsForPost($postId)
{
    require 'dbconnect.php';
    $pdo = new PDO($dsn,$username,$password);
    $sql = "
        SELECT
            comment_id, user_name, content, created_at, website
        FROM
            comments
        WHERE
            post_id = :post_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('post_id' => $postId, )
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function redirectAndExit($script)
{
    // Get the domain-relative URL (e.g. /blog/whatever.php or /whatever.php) and work
    // out the folder (e.g. /blog/ or /).
    $relativeUrl = $_SERVER['PHP_SELF'];
    $urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, '/') + 1);
    // Redirect to the full URL (http://myhost/blog/script.php)
    $host = $_SERVER['HTTP_HOST'];
    $fullUrl = 'http://' . $host . $urlFolder . $script;
    header('Location: ' . $fullUrl);
    exit();
}

/**
 * Returns the number of comments for the specified post
 *
 * @param integer $postId
 * @return integer
 */
function countCommentsForPost($postId)
{
    require 'dbconnect.php';
    $pdo = new PDO($dsn,$username,$password);
    $sql = " SELECT * FROM comments WHERE post_id = :post_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('post_id' => $postId, )
    );
    return (int) $stmt->fetchColumn();
}

function getSqlDateForNow()
{
    return date('Y-m-d H:i:s');
}

/**
 * Converts unsafe text to safe, paragraphed, HTML
 *
 * @param string $text
 * @return string
 */
function convertNewlinesToParagraphs($text)
{
    $escaped = htmlEscape($text);
    return '<p>' . str_replace("\n", "</p><p>", $escaped) . '</p>';
}


/**
 * Writes a comment to a particular post
 *
 * @param PDO $pdo
 * @param integer $postId
 * @param array $commentData
 * @return array
 */
function addCommentToPost(PDO $pdo, $postId, array $commentData)
{
    $errors = array();
    // Do some validation
    if (empty($commentData['user_name']))
    {
        $errors['user_name'] = 'A name is required';
    }
    if (empty($commentData['content']))
    {
        $errors['content'] = 'A comment is required';
    }
    // If we are error free, try writing the comment
    if (!$errors)
    {
        $sql = "
            INSERT INTO
            comments
            (user_name, website, content, created_at, post_id)
            VALUES(:name, :website, :text, :created_at, :post_id)
        ";
        $stmt = $pdo->prepare($sql);
        if ($stmt === false)
        {
            throw new Exception('Cannot prepare statement to insert comment');
        }

        $result = $stmt->execute(
            array_merge(
                $commentData,
                array('post_id' => $postId, 'created_at' => getSqlDateForNow())
            )
        );
        if ($result === false)
        {
            // @todo This renders a database-level message to the user, fix this
            $errorInfo = $stmt->errorInfo();
            if ($errorInfo)
            {
                $errors[] = $errorInfo[2];
            }
        }
    }
    return $errors;
}
?>