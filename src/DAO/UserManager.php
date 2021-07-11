<?php

namespace App\DAO;

use App\Model\User;

class UserManager extends DAO

{

    public function findByUsername($username): ? User
    {
        $result = $this->createQuery('SELECT * FROM user WHERE username = ?', [$username]);
        if (false === $object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    public function register(User $user)
    {
        $this->createQuery(
            'INSERT INTO user(username, password)VALUES(?,?)',
            $this->buildValues($user)
        );
        return true;
    }
    private function buildValues(User $user): array
    {
        return[
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