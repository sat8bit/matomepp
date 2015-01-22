CREATE TABLE blogs (
    blog_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(128),
    index_url VARCHAR(128) UNIQUE KEY,
    rss_url VARCHAR(128),
    updated_at TIMESTAMP
)
