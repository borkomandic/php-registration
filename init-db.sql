CREATE TABLE IF NOT EXISTS user
(
    id       INT auto_increment PRIMARY KEY,
    name     VARCHAR(255) NOT NULL,
    email    VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
    );

CREATE TABLE IF NOT EXISTS user_log
(
    id       INT auto_increment PRIMARY KEY,
    action   VARCHAR(255) NOT NULL,
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );