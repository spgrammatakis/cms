<?php

namespace lib;

class PostManager extends DbConnection{
    
public function __construct(){
        parent::__construct();
    }
    
public function getPostRow($postId)
{
    $sql ="SELECT title, body, created_at FROM posts WHERE post_id = :post_id";
    $this->prepareStmt($sql);
    $this->bind(':post_id',$postId);
    return $this->All();
}
public function countCommentsForPost($postId)
{
    $this->prepareStmt('SELECT * FROM comments WHERE post_id = :post_id');
    $this->bind('post_id',$postId);
    $this->run();
    return (int) $this->rowCount();
}

public function updatePost($postId,$postTitle,$postBody){
    $errors = array();
    
    $date = Utilities::getSqlDateForNow();
    if (empty($postId))
    {
        $errors['post_id'] = 'An id is required';
    }    
    if (empty($postTitle))
    {
        $errors['post_title'] = 'A title is required';
    }
    if (empty($postBody))
    {
        echo "empty post title";
        $errors['post_body'] = 'A body is required';
    }
    if (!$errors){
        
    $sql = "
    UPDATE posts
    SET post_id=:post_id, title=:post_title, body=:post_body
    WHERE post_id=:post_id;
    ";
    $this->prepareStmt($sql);
    $this->bind(':post_id',$postId);
    $this->bind(':post_title',$postTitle);
    $this->bind(':post_body',$postBody);;
    $this->run();
    } 

    return $errors;
}

public function addCommentToPost($postId, array $commentData)
{
    $errors = array();

    if (empty($commentData['user_name']))
    {
        $errors['user_name'] = 'A name is required';
    }
    if (empty($commentData['content']))
    {
        $errors['content'] = 'A comment is required';
    }

    if (!$errors)
    {
        $sql = "
            INSERT INTO
            comments
            (comment_id,user_name, website, content, created_at, post_id)
            VALUES(:comment_id,:user_name, :website, :content, :created_at, :post_id)
        ";
        $commentData = array_merge(
                $commentData,
                array('post_id' => $postId, 'created_at' => Utilities::getSqlDateForNow(), 'comment_id'=>bin2hex(random_bytes(10)))
            );
        $this->prepareStmt($sql);
        $this->runArray($commentData);
    }
    return $errors;
}

public function getCommentsForPost($postId)
{
    $pdo = $this->dbh;
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
    return $stmt->fetchAll();
}

public function getPosts($limit = NULL){
    $limit = is_null($limit) ? PHP_INT_MAX : $limit;
    $this->prepareStmt("SELECT post_id,title,body,created_at FROM posts LIMIT $limit");
    return $row  = $this->All();
}

public function addPost(){
if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) return false;
if( (!isset($_GET['title']) || empty($_COOKIE['title'])) || 
    (!isset($_GET['body']) || empty($_COOKIE['body'])) ) return false;
try {
    $author_id = 0;
    $title = $_GET['title'];
    $body = $_GET['body'];
    $sql = "INSERT INTO posts(author_id,title, body)
            VALUES (:author_id,:title, :body)";
    $this->prepareStmt($sql);
    $this->bind(':author_id',$author_id);
    $this->bind(':title',$title);
    $this->bind(':body',$body);
    $this->run();

}
    catch (\PDOException $e) {
        exit("Connection failed: " . $e->getMessage());
    }
//Utilities::redirectAndExit('index.php');
}
public function delete($commentid){
    $stmt = $this->db->prepare("DELETE FROM posts WHERE id=:id");
    $stmt->bindparam(":id",$commentid);
    $stmt->execute();
    return true;
   }
}
?>