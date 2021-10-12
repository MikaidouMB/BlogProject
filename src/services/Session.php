<?php


namespace App\services;


class Session
{
    public ?int $id = null;
    public string $username;
    private string $password;
    private int $userId;
    private ?string $role = null;

    public function set(string $string, string $string1)
    {
        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0;
        } else {
            $_SESSION['count']++;
        }
    }
    /**
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return Session
     */
    public function setId(int $id): Session
    {
        $this->id = $id;
        return $this;
    }
    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Session
     */
    public function setUserId(int $userId): Session
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param string $username
     * @return Session
     */
    public function setUsername(string $username): Session
    {
        $this->username = $username;
        return $this;
    }
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Session
     */
    public function setPassword(string $hashedPassword): Session
    {
        $this->password = $hashedPassword;
        return $this;
    }

    /**
     * @return bool
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param bool $role
     * @return Session
     */

    public function setRole(string $role): Session
    {
        $this->role = $role;
        return $this;
    }
}