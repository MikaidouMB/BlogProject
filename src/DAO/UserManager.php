<?php
namespace App\DAO;

use App\Model\User;

class UserManager extends DAO
{
    /**
     * @param $userId
     * @return User|null
     */
    public function findPostAuthorByUserId($userId): ?User
    {
        $result = $this->createQuery('SELECT * from user WHERE user.id = ?', $userId);
        if (!$object = $result->fetchObject()) {
            return null;
        }
        return $this->buildObject($object);
    }

    /**
     * @param $username
     * @return mixed
     */
    public function checkIfUserExist($username)
    {
        $result = $this->createQuery('SELECT * FROM user WHERE username = ?', [$username]);
        if ($result->rowCount() > 0) {
            return $result->fetch(\PDO::FETCH_ASSOC);
        }
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function register(User $user)
    {
        $this->createQuery(
            'INSERT INTO user(id, username, password,email, role, is_valid)VALUES(?,?,?,?,?,?)',
            $result = array_merge($this->buildValues($user))
        );
        return $result;
    }

    /**
     * @return array
     */
    public function findAllUsers(): array
    {
        $result = $this->createQuery('SELECT * FROM user');
        $users = [];
        foreach ($result->fetchAll() as $user) {
            $users[]= $this->buildObject($user);
        }
        return $users;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function delete($userId): bool
    {
        $result = $this->createQuery('DELETE FROM user WHERE id = ?', [$userId]);
        return 1 <= $result->rowCount();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        $result = $this->createQuery(
            'UPDATE user SET id = ?, username = ?, password = ?, email = ?, role = ?, is_valid = ?  WHERE id = ?',
            array_merge($this->buildValues($user), [$user->getUserId()])
        );
        return 1 <= $result->rowCount();
    }

    /**
     * @param User $user
     * @return array
     */
    private function buildValues(User $user): array
    {
        return [
            $user->getUserId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getEmail(),
            $user->getRole(),
            $user->getIsValid()
        ];
    }

    /**
     * @param object $user
     * @return User
     */
    private function buildObject(object $user): User
    {
        return (new User())
            ->setUserId($user->id)
            ->setUsername($user->username)
            ->setPassword($user->password)
            ->setEmail($user->email)
            ->setRole($user->role)
            ->setIsValid($user->is_valid);
    }
}