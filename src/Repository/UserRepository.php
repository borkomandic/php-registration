<?php

namespace App\Repository;

use App\Utils\Database;

class UserRepository
{
    public function findByEmail(string $email)
    {
        $link = Database::getInstance();
        $stmt = $link->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        return $user;
    }

    public function insertUser(string $email, string $password)
    {
        $link = Database::getInstance();
        $stmt = $link->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $userId = $stmt->insert_id;
        $stmt->close();

        return $userId;
    }

    public function insertUserLog(int $userId, string $action)
    {
        $link = Database::getInstance();
        $stmt = $link->prepare("INSERT INTO user_log (user_id, action, log_time) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $userId, $action);
        $stmt->execute();
        $stmt->close();
    }
}
