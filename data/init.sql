DROP TABLE IF EXISTS posts;

CREATE TABLE posts (
post_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
author_id INT(10) NOT NULL,
title VARCHAR(50) NOT NULL,
body VARCHAR(255) NOT NULL,
created_at DATE NOT NULL,
updated_at DATE
)DEFAULT CHARSET=utf8;

INSERT INTO posts(title, body, author_id, created_at)
    VALUES("Here's our first post","This is the body of the first post.It is split into paragraphs.",1,now())
;