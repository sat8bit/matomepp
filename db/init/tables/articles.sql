CREATE TABLE articles (
    article_id INT PRIMARY KEY AUTO_INCREMENT,
    url   VARCHAR(255) UNIQUE KEY,
    title VARCHAR(64),
    description VARCHAR(1024),
    date  datetime,
    blog_id INT,
    updated_at TIMESTAMP
);
