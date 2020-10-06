<?php
class PostManager extends DbConnection{
    
public function __construct(){
        parent::__construct();
    }
    
public function getPostRow($postId)
{
    $sql ="SELECT title, body, created_at FROM posts WHERE post_id = :post_id";
    $this->prepareStmt($sql);
    $this->bind(':post_id',$postId);
    $this->run();
    return $this->stmt->fetch();
}
public function countCommentsForPost($postId)
{
    $this->prepareStmt('SELECT * FROM comments WHERE post_id = :post_id');
    $this->bind('post_id',$postId);
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
            (user_name, website, content, created_at, post_id)
            VALUES(:user_name, :website, :content, :created_at, :post_id)
        ";
        $commentData = array_merge(
                $commentData,
                array('post_id' => $postId, 'created_at' => Utilities::getSqlDateForNow())
            );
        $this->prepareStmt($sql);
        $this->runArray($commentData);
        if ($result === false)
        {
            $errorInfo = $this->errorInfo();
            if ($errorInfo)
            {
                $errors[] = $errorInfo[2];
            }
        }
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

public function getPosts(){
    $this->prepareStmt("SELECT post_id,title,body,created_at FROM posts");
    $row  = $this->All();
    
    foreach($row as $row):
        echo "<div class=post-title>";
        echo Utilities::htmlEscape($row['title']);
        echo "</div>";
        echo "<div class=post-date>";
        echo Utilities::convertSqlDate($row['created_at']);
        echo "</div>";
        echo "<div class=post-comment-number>";
        echo $this->countCommentsForPost($row['post_id']). " comments";
        echo "</div>";
        echo "<div class=post-body>";
        echo "<p>";
        echo Utilities::htmlEscape($row['body']);
        echo "</p>";
        echo "</div>";
        echo "<a href='view-post.php?post_id=". Utilities::htmlEscape($row['post_id']) ."'>Read more...</a>";
    endforeach;
}

public function addPost(){//NEEDS REFACTORING
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
     echo '<h1>You are not an authorised user</h1>';
     die();
}
if (isset($_GET['submit'])) {
    $title = $_GET['title'];
    $body = $_GET['body'];
}
try {
    $title = $_GET['title'];
    $summary = $_GET['summary'];
    $body = $_GET['body'];
    $sql = "INSERT INTO posts(title, body)
            VALUES (':title', ':body')))";
    $this->prepareStmt($sql);
    $this->bind(':title',$title);
    $this->bind(':body',$body);
    $this->run();

}
    catch (PDOException $e) {
        exit("Connection failed: " . $e->getMessage());
    }
Utilities::redirectAndExit('index.php');
}
public function delete($commentid){
    $stmt = $this->db->prepare("DELETE FROM posts WHERE id=:id");
    $stmt->bindparam(":id",$commentid);
    $stmt->execute();
    return true;
   }
}
?>