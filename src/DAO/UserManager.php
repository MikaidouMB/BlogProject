<?php

namespace App\DAO;

use App\Model\User;

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

    public function showUsers(): array
    {
        $result = $this->createQuery('SELECT * FROM user');

        $users = [];
        foreach ($result->fetchAll() as $user) {
            $users[] = $this->buildObject($user);
        }
        return $users;
    }

    public function findUser($username)
    {
        $result = $this->createQuery('SELECT * FROM user WHERE username = ?', [$username]);
        if ($result->rowCount() > 0) {
            return $result->fetch(\PDO::FETCH_OBJ);
            var_dump($result);
        }
    }

    public function register(User $user)
    {
        $this->createQuery('INSERT INTO user(id,username, password)VALUES(?,?,?)',
            array_merge($this->buildValues($user)));
        var_dump($user);
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
            ->setUsername($user->username)
            ->setPassword($user->password);
        return $user;
    }

}