<?php
function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

function convertSqlDate($sqlDate)
{
    /* @var $date DateTime */
    $date = DateTime::createFromFormat('Y-m-d', $sqlDate);
    return $date->format('d M Y');
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

?>