CREATE TABLE accesses (
    article_id INT PRIMARY KEY,
    count INT NOT NULL DEFAULT 0,
    updated_at TIMESTAMP
)
