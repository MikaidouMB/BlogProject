<?php

namespace App\DAO;

use App\Model\User;
use App\Model\Post;
class UserManager extends DAO

{

    private $user;

    public function findByUsername($username): ? User
    {
        $result = $this->createQuery('SELECT * FROM user WHERE username = ?', [$username]);
        if (false === $object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    public function findUsernameByUserId($userId)
    {

        $result = $this->createQuery('SELECT * from user WHERE user.id = ?', $userId);
        return $result->fetch(\PDO::FETCH_OBJ);
    }

    public function findUser($username)
    {
        $result = $this->createQuery('SELECT * FROM user WHERE username = ?', [$username]);
        if ($result->rowCount() > 0) {
            return $result->fetch(\PDO::FETCH_OBJ);
        }
    }

    public function register(User $user)
    {
        $this->createQuery('INSERT INTO user(id,username, password)VALUES(?,?,?)',
            array_merge($this->buildValues($user)));
        return true;
    }
    private function buildValues(User $user): array
    {
        return[
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),

        ];
    }
    private function buildObject(object $user):User
    {
        return (new User())
            ->setId($user->id)
            ->setUsername($user->username)
            ->setPassword($user->password);
        return $user;
    }

}