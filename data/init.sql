DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
post_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
author_id INT(10) NOT NULL,
title VARCHAR(50) NOT NULL,
body VARCHAR(255) NOT NULL,
created_at DATETIME NOT NULL,
updated_at DATETIME
)DEFAULT CHARSET=utf8;

INSERT INTO posts(title, body, author_id, created_at)
VALUES("Here's our first post","This is the body of the first post.It is split into paragraphs.",1,now());

DROP TABLE IF EXISTS comments;

CREATE TABLE comments (
    comment_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT(10) NOT NULL,
    user_name VARCHAR(20) NOT NULL,
    website VARCHAR(30),
    content VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME
)DEFAULT CHARSET=utf8;

INSERT INTO comments(post_id, created_at, user_name, website, content)
VALUES(1,now(),'Spyros','http://example.com/',"This is Spyros's contribution");