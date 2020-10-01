DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
post_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
author_id INT(10) NOT NULL,
title VARCHAR(50) NOT NULL,
body VARCHAR(255) NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8;

INSERT INTO posts(title, body, author_id, created_at)
VALUES("Here's our first post","This is the body of the first post.It is split into paragraphs.",1,now());

DROP TABLE IF EXISTS comments;

CREATE TABLE comments (
    comment_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    post_id INT(10) NOT NULL,
    user_name VARCHAR(20) NOT NULL,
    website VARCHAR(30),
    content VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8;

INSERT INTO comments(post_id, created_at, user_name, website, content)
VALUES(1,now(),'Spyros','http://example.com/',"This is Spyros's contribution");

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(30) NOT NULL,
    modification_time  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_enabled BOOLEAN NOT NULL
)DEFAULT CHARSET=utf8;

INSERT INTO users(username, password)
VALUES('admin','admin');
/*DROP TABLE IF EXISTS auth_tokens;

CREATE TABLE auth_tokens (
    token_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    token VARCHAR(33),
    userid INT(10) UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL
)DEFAULT CHARSET=utf8;*/

DROP TABLE IF EXISTS users_metadata;

CREATE TABLE users_metadata(
        meta_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        user_id INT(10) NOT NULL,
        session_tokens LONGTEXT NOT NULL,
        initiated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8;