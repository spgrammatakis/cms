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

        $sql = "
            INSERT INTO
            comments
            (comment_id,user_id,content, created_at, post_id)
            VALUES(:comment_id,:user_id, :content, :created_at, :post_id)
        ";
        $commentData = array_merge(
                $commentData,
                array('post_id' => $postId, 'created_at' => Utilities::getSqlDateForNow(), 'comment_id'=>bin2hex(random_bytes(10)))
            );
        $this->prepareStmt($sql);
        $this->runArray($commentData);
    return;
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

public function getCommentRow(string $commentID){
    $sql="SELECT * FROM comments WHERE comment_id=:comment_id";
    $this->prepareStmt($sql);
    $this->bind(':comment_id', $commentID);
    return $this->SingleRow();
}

public function getUserComments(string $userID){
    $sql="SELECT * FROM comments WHERE user_id=:user_id";
    $this->prepareStmt($sql);
    $this->bind(':user_id', $userID);
    return $this->All();
}

public function updateComment($commentData){
    $sql = "UPDATE comments
    SET content=:content
    WHERE comment_id=:comment_id
    "; 
    $this->prepareStmt($sql);
    $this->bind(':content',$commentData['comment-text']);
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

public function getAllComments($limit = NULL){
$sql="SELECT * FROM comments";
$this->prepareStmt($sql);
return $this->All();
}

public function getCommentsForPost($postId,$limit = NULL)
{
    $limit = is_null($limit) ? PHP_INT_MAX : $limit;
    $sql = "SELECT
            comment_id, user_id, content, created_at
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

public function addPost(array $postData){
    $sql = "INSERT INTO posts(post_id,author_id,title, body, created_at)
            VALUES (:post_id,:author_id, :title, :body, :created_at)";
    $this->prepareStmt($sql);
    $this->bind(':post_id',$postData['post-id']);
    $this->bind(':author_id',$postData['author-id']);
    $this->bind(':title',$postData['post-title']);
    $this->bind(':body',$postData['post-body']);
    $this->bind(':created_at',Utilities::getSqlDateForNow());
    $this->run();
}

public function deletePost(){
    
}

public function deleteComment($commentID){
    $sql = "DELETE FROM comments WHERE comment_id=:comment_id";
    $this->prepareStmt($sql);
    $this->bind(":comment_id",$commentID);
    return $this->run;
   }
}

?>