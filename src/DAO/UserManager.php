<?php

namespace App\DAO;

use App\Model\User;

class UserManager extends DAO
{
    public function findPostAuthorByUserId($userId): ?User
    {
        $result = $this->createQuery('SELECT * from user WHERE user.id = ?', $userId);
        if (!$object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    public function checkIfUserExist($username)
    {
        $result = $this->createQuery('SELECT * FROM user WHERE username = ?', [$username]);
        if ($result->rowCount() > 0) {
            return $result->fetch(\PDO::FETCH_OBJ);
        }
    }

    public function register(User $user)
    {
        $this->createQuery('INSERT INTO user(id, username, password, role)VALUES(?,?,?,?)',
            $result = array_merge($this->buildValues($user)));

        $_SESSION['newsession'] = $result;
        return $result;
    }

    public function findAllUsers(): array
    {
        $result = $this->createQuery('SELECT * FROM user');
        $users = [];
        foreach ($result->fetchAll() as $user){
            $users[]= $this->buildObject($user);
        }
        return $users;
    }

    public function delete($userId): bool
    {
        $result = $this->createQuery('DELETE FROM user WHERE id = ?', [$userId]);
        return 1 <= $result->rowCount();
    }

    public function update(User $user): bool
    {
        $result = $this->createQuery(
            'UPDATE user SET id = ?, username = ?, password = ?, role = ? WHERE id = ?',
            array_merge($this->buildValues($user), [$user->getId()])
        );

        return 1 <= $result->rowCount();
    }

    private function buildValues(User $user): array
    {
        return [
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getRole(),

        ];
    }

    private function buildObject(object $user):User
    {
        return (new User())
            ->setId($user->id)
            ->setUsername($user->username)
            ->setPassword($user->password)
            ->setRole($user->role);

        return $user;
    }
}