<?php

namespace lib;

class PostManager extends DbConnection{
    
public function __construct(){
        parent::__construct();
    }
    
public function getPostRow($postId)
{
    $sql ="SELECT post_id,title, body, created_at FROM posts WHERE post_id = :post_id";
    $this->prepareStmt($sql);
    $this->bind(':post_id',$postId);
    return $this->SingleRow();
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
            (comment_id,user_id, website, content, created_at, post_id)
            VALUES(:comment_id,:user_id, :website, :content, :created_at, :post_id)
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

public function reportPost(string $id){
    if(!($this->postCheckIfAlreadyExists($id))){
        return http_response_code(404);}
    $sql = "UPDATE posts
    SET reported=:reported
    WHERE post_id=:post_id
    "; 
    $this->prepareStmt($sql);
    $this->bind(':reported',1);
    $this->bind(':post_id',$id);
    $this->run();
    return http_response_code(200);
}

public function getReportedPosts($limit = NULL){
    $limit = is_null($limit) ? PHP_INT_MAX : $limit;    
    $sql="SELECT
            *
        FROM
            posts
        WHERE
            reported = TRUE
        LIMIT
            :limit";
    $this->prepareStmt($sql);
    $this->bind(":limit",$limit);
    return $this->All();
}

public function postCheckIfAlreadyExists(string $postID){
    $sql = "SELECT post_id FROM posts WHERE post_id = :post_id";
    $this->prepareStmt($sql);
    $this->bind(':post_id', $postID);
    $this->run();
    return $this->rowCount() == 1;
}

public function reportComment(string $id){
    if(!($this->commentCheckIfAlreadyExists($id))){
        return http_response_code(404);}
    $sql = "UPDATE comments
    SET reported=:reported
    WHERE comment_id=:comment_id
    "; 
    $this->prepareStmt($sql);
    $this->bind(':reported',1);
    $this->bind(':comment_id',$id);
    $this->run();
    return http_response_code(200);
}

public function commentCheckIfAlreadyExists(string $commentID){
    $sql = "SELECT comment_id FROM comments WHERE comment_id = :comment_id";
    $this->prepareStmt($sql);
    $this->bind(':comment_id', $commentID);
    $this->run();
    return $this->rowCount() == 1;
}

public function getUserComments(string $username){
    $sql="SELECT * FROM comments WHERE user_name=:user_name";
    $this->prepareStmt($sql);
    $this->bind(':user_name', $username);
    return $this->All();
}

public function updateComment($commentData){
    $sql = "UPDATE comments
    SET content=:content,website=:website
    WHERE comment_id=:comment_id
    "; 
    $this->prepareStmt($sql);
    $this->bind(':content',$commentData['comment-text']);
    $this->bind(':website',$commentData['comment-website']);
    $this->bind(':comment_id',$commentData['comment-id']);
    return $this->run();

}
public function getReportedComments($limit = NULL){
    $limit = is_null($limit) ? PHP_INT_MAX : $limit;    
    $sql="SELECT
            *
        FROM
            comments
        WHERE
            reported = TRUE
        LIMIT
            :limit";
    $this->prepareStmt($sql);
    $this->bind(":limit",$limit);
    return $this->All();
}

public function getCommentsForPost($postId,$limit = NULL)
{
    $limit = is_null($limit) ? PHP_INT_MAX : $limit;
    $sql = "SELECT
            comment_id, user_id, content, created_at, website
        FROM
            comments
        WHERE
            post_id = :post_id
        LIMIT
            :limit";
    $this->prepareStmt($sql);
    $this->bind(':post_id',$postId);
    $this->bind(":limit",$limit);
    return $this->All();
}

public function getPosts($limit = NULL){
    $limit = is_null($limit) ? PHP_INT_MAX : $limit;
    $this->prepareStmt("SELECT post_id,title,body,created_at FROM posts LIMIT :limit");
    $this->bind(":limit",$limit);
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
}
public function delete($commentid){
    $stmt = $this->db->prepare("DELETE FROM posts WHERE id=:id");
    $stmt->bindparam(":id",$commentid);
    $stmt->execute();
    return true;
   }
}
?>