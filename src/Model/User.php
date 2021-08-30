<?php


namespace App\Model;


class User
{
    private int $id;
    private string $username;
    private string $password;
    private $role;

    /**
     * @return integer
     */
  /*  public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return User
     */
    /*public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }
*/
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
    /*   public function getEmail(): string
       {
           return $this->email;
       }*/

    /**
     * @param string $email
     * @return User
     */
    /*
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }
*/
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $hashedPassword): User
    {
        $this->password = $hashedPassword;
        return $this;
    }

    /**
     * @return bool
     */
    public function getRole():? int
    {
        return $this->role;
    }

    /**
     * @param bool $role
     * @return User
     */
    public function setRole(int $role): User
    {
        $this->role = $role;
        return $this;
    }

}

