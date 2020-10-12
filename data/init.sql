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

/*INSERT INTO users(username, password)
VALUES('admin','$2y$10$LmNcpUSpES6plyPDtnBIG.SeFcN761AcsZ/OPeKFyxMsnrxPB9fjm');

INSERT INTO users(username, password)
VALUES('author','$2y$10$QPNYMR4U4FTR3yxUB8XiteT5yrJKhln2W89Hdqy4aPeh4COzY8NXC');*/
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
        username VARCHAR(20) NOT NULL,
        session_tokens LONGTEXT NOT NULL,
        user_role LONGTEXT NOT NULL,
        expire_at DATETIME NOT NULL,
        initiated_at DATETIME DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8;

/*INSERT INTO users_metadata(user_id, user_role)
VALUES(0,"guest");

INSERT INTO users_metadata(user_id,user_role)
VALUES(1,"admin");

INSERT INTO users_metadata(user_id,user_role)
VALUES(2,"author");*/

DROP TABLE IF EXISTS users_options;

CREATE TABLE users_options(
    option_id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_role LONGTEXT NOT NULL,
    user_privileges LONGTEXT NOT NULL

)DEFAULT CHARSET=utf8;

INSERT INTO users_options(user_role,user_privileges)
VALUES("admin",'a:1:{s:5:"admin";a:5:{s:12:"create_users";i:1;s:9:"edit_user";i:1;s:10:"edit_posts";i:1;s:13:"edit_comments";i:1;s:12:"upload_files";i:1;}}');

INSERT INTO users_options(user_role,user_privileges)
VALUES("author",'a:1:{s:6:"author";a:3:{s:15:"edit_self_posts";i:1;s:9:"edit_self";i:1;s:12:"upload_files";i:1;}}');

INSERT INTO users_options(user_role,user_privileges)
VALUES("guest",'a:1:{s:5:"guest";a:1:{s:13:"post_comments";i:1;}}');