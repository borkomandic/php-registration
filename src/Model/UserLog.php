<?php

namespace App\Model;

class UserLog
{
    private $id;
    private $userId;
    private $action;
    private $logTime;

    public function __construct($id, $userId, $action, $logTime)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->action = $action;
        $this->logTime = $logTime;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getLogTime()
    {
        return $this->logTime;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function setLogTime($logTime)
    {
        $this->logTime = $logTime;
    }
}
