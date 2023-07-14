CREATE DATABASE students;

USE students;

drop table post_comments;

CREATE TABLE post_comments
( comment_id int NOT NULL AUTO_INCREMENT,
 post_id int, 
 full_name VARCHAR(100), 
 email VARCHAR(100),
 post_comment VARCHAR(500),
 CONSTRAINT post_comments_pk PRIMARY KEY (comment_id),
 UNIQUE (post_id, full_name)
 );
 
INSERT INTO post_comments (post_id,  full_name, email, post_comment) 
VALUES(1,'village','aaa@aaa.aaa', 'asdasd');

INSERT INTO post_comments (post_id, full_name, email,post_comment) 
VALUES(1, 1, 'My Name', 'email@gmail.com', 'This is sample comment');

INSERT INTO post_comments (post_id, comment_id, full_name, email, post_comment) 
VALUES(1, 2, 'My Name 2', 'email@gmail.com2', 'This is sample comment2');

select * from `students`.`post_comments` 
where post_id = 1 
order by comment_id desc;