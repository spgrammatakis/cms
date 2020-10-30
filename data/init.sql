DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
post_id VARCHAR(20) PRIMARY KEY NOT NULL,
author_id INT(10) NOT NULL,
title VARCHAR(50) NOT NULL,
body VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8;

INSERT INTO posts(post_id,title, body, author_id, created_at)
VALUES("f2b8de889c344ab5bae0","Here's our first post","This is the body of the first post.It is split into paragraphs.",1,now());

DROP TABLE IF EXISTS comments;

CREATE TABLE comments (
    comment_id VARCHAR(20) PRIMARY KEY NOT NULL UNIQUE,
    post_id INT(10) NOT NULL,
    user_name VARCHAR(20) NOT NULL,
    website VARCHAR(30),
    content LONGTEXT NOT NULL,
    reported BOOLEAN NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id VARCHAR(20) PRIMARY KEY NOT NULL UNIQUE,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(30) NOT NULL,
    modification_time  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    reported BOOLEAN NOT NULL DEFAULT 0
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS users_metadata;

CREATE TABLE users_metadata(
        meta_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        user_id VARCHAR(20) NOT NULL,
        username VARCHAR(20) NOT NULL,
        session_tokens LONGTEXT NOT NULL,
        user_role LONGTEXT NOT NULL,
        expire_at DATETIME NOT NULL,
        initiated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
)DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS users_options;

CREATE TABLE users_options(
    option_id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_role LONGTEXT NOT NULL,
    user_privileges LONGTEXT NOT NULL
)DEFAULT CHARSET=utf8;

INSERT INTO users_options(user_role,user_privileges)
VALUES("admin",'{"create_users":1,"edit_user":1,"edit_posts":1,"edit_comments":1,"upload_files":1}');

INSERT INTO users_options(user_role,user_privileges)
VALUES("author",'{"edit_self_posts":1,"edit_self":1,"upload_files":1}');

INSERT INTO users_options(user_role,user_privileges)
VALUES("commenter",'{"post_comments":1}');