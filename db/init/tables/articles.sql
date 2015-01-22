CREATE TABLE articles (
    url   VARCHAR(255) PRIMARY KEY,
    title VARCHAR(64),
    description VARCHAR(1024),
    date  datetime,
    blog_id INT,
    updated_dt TIMESTAMP
);
