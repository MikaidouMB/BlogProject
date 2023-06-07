<?php
namespace App\Model;

class User
{
    private ?int $userId = null;
    private string $username;
    private string $password;
    private ?string $role = null;
    private ?string $email = null;
    private ?int $is_valid = null;

    /**
     * @return integer
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param integer $userId
     * @return User
     */
    public function setUserId(int $userId): User
    {
        $this->userId = $userId;
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
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
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
     * @param string $hashedPassword
     * @return User
     */
    public function setPassword(string $hashedPassword): User
    {
        $this->password = $hashedPassword;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return User
     */

    public function setRole(string $role): User
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsValid(): ?int
    {
        return $this->is_valid;
    }

    /**
     * @param int|null $is_valid
     * @return User
     */
    public function setIsValid(?int $is_valid): User
    {
        $this->is_valid = $is_valid;
        return $this;
    }
}
