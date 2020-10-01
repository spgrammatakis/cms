<?php

require 'common-functions.php';

class DbConnection{
private $host = "127.0.0.1";
private $dbName = "cms";
private $username = "admin";
private $password = "admin";
private $charset = 'utf8';

private $dbh;
private $error;
private $stmt;

public function __construct(){
    $dsn     = "mysql:host=" . $this->host . ";dbname=" . $this->dbName . ";charset=" . $this->charset;  
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true    
    );
try{
	$this->dbh = new PDO($dsn, $this->username, $this->password, $options);
}
catch(PDOException $e)
{
    $this->error = $e->getMessage();
    echo "Connection failed: " . $e->getMessage();
	die();
 }

}

public function prepareStmt($query){
    $this->stmt = $this->dbh->prepare($query);
}

public function bind($param, $value, $type=null){
    if (is_null($type)) {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;  
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
    }
    $this->stmt->bindValue($param, $value, $type);
}

public function run()
{   
    return $this->stmt->execute();

}

public function runArray($data)
{   
    return $this->stmt->execute($data);
}

public function All(){
    $this->run();
    return $this->stmt->fetchall();
}

public function rowCount(){
    $this->run();
    return $this->stmt->rowCount();
}

public function getDatabase():string{
    return dirname(__DIR__, 1).'/data/init.sql';
}


public function htmlEscape($html)
{
    //return htmlentities($html, ENT_HTML5, 'UTF-8');
    $array = array(
        1 => "<b>",
        2 => "<strong>",
        3 => "<a>",
        4 => "<i>",
        5 => "<u>"
    );
    return strip_tags($html,$array);
}

public function convertSqlDate($sqlDate)
{
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $sqlDate);
    return $date->format('Y-m-d H:i:s');
}

public function getPostRow($postId)
{
    $sql ="SELECT title, body, created_at FROM posts WHERE post_id = :post_id";
    $this->prepareStmt($sql);
    $this->bind(':post_id',$postId);
    $this->run();
    return $this->stmt->fetch();
}

public function SingleRow(){
    $this->run();
    return $this->stmt->fetch();
    } 

public function countCommentsForPost($postId)
{
    $this->prepareStmt('SELECT * FROM comments WHERE post_id = :post_id');
    $this->bind('post_id',$postId);
    return (int) $this->rowCount();
}


public function convertNewlinesToParagraphs($text)
{
    $escaped = htmlEscape($text);
    return '<p>' . str_replace("\n", "</p><p>", $escaped) . '</p>';
}

public function updatePost($postId,$postTitle,$postBody){
    $errors = array();
    
    $date = getSqlDateForNow();
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
                array('post_id' => $postId, 'created_at' => getSqlDateForNow())
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

public function tryLogin(PDO $pdo, $username, $password)
{
    $sql = "
        SELECT
            password
        FROM
            users
        WHERE
            username = :username
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('username' => $username, )
    );
    $hash = $stmt->fetchColumn();
    $success = password_verify($password, $hash);
    return $success;
}
public function getPosts(){
    $this->prepareStmt("SELECT post_id,title,body,created_at FROM posts");
    $row  = $this->All();
    
    foreach($row as $row):
        echo "<div class=post-title>";
        echo $this->htmlEscape($row['title']);
        echo "</div>";
        echo "<div class=post-date>";
        echo $this->convertSqlDate($row['created_at']);
        echo "</div>";
        echo "<div class=post-comment-number>";
        echo $this->countCommentsForPost($row['post_id']). " comments";
        echo "</div>";
        echo "<div class=post-body>";
        echo "<p>";
        echo $this->htmlEscape($row['body']);
        echo "</p>";
        echo "</div>";
        echo "<a href='view-post.php?post_id=". $this->htmlEscape($row['post_id']) ."'>Read more...</a>";
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
redirectAndExit('index.php');
}
public function delete($commentid){
    $stmt = $this->db->prepare("DELETE FROM posts WHERE id=:id");
    $stmt->bindparam(":id",$commentid);
    $stmt->execute();
    return true;
   }

public function sessionCheck(){
    if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])) return;
    $tokens = serialize(array("session_token"=>$_COOKIE["session_token"]));
    echo $tokens . "</br>";
    $username = $_COOKIE["user_name"];
    echo $username;
    $sql = "SELECT user_id FROM users WHERE username = :username";
    $this->prepareStmt($sql);
    $this->bind(':username', $username);
    if($this->run()){              
        if($this->rowCount() == 1){
                if($row = $this->SingleRow()){
                    $userID = $row['user_id'];
                }
    }
    if(!isset($userID) || empty($userID)) return;
    $sql = "
    INSERT INTO
    users_metadata
    (user_id, session_tokens)
    VALUES(:user_id, :session_tokens)
    ";
    $remoteAddress = serialize(array("remote_addr" =>$_SERVER['REMOTE_ADDR']));
    $sql1="
    UPDATE users_metadata
    
    SET session_tokens = CONCAT(session_tokens,'$remoteAddress')";
    $this->prepareStmt($sql1);
    $this->run();
    $this->prepareStmt($sql);
    $this->bind(':user_id',$userID);
    $this->bind(':session_tokens',$tokens);
    $this->run();
    }
}
public function sessionIfAlreadyExists(){
    if(!isset($_COOKIE["user_name"]) || empty($_COOKIE['user_name'])){
        return;
        }
}
}
?>