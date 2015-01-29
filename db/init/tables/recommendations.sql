CREATE TABLE recommendations (
    recommendation_id INT PRIMARY KEY AUTO_INCREMENT,
    keyword VARCHAR(32) UNIQUE KEY,
    updated_at TIMESTAMP
);
