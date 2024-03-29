CREATE TABLE IF NOT EXISTS user
(
    id       INT auto_increment PRIMARY KEY,
    name     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    email    VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS user_log
(
    id       INT auto_increment PRIMARY KEY,
    user_id   INT NOT NULL,
    action   VARCHAR(255) NOT NULL,
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );