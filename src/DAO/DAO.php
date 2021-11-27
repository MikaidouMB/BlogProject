<?php

namespace App\DAO;

use App\Model\Input;

abstract class DAO
{
    private \PDO $database;
    private Input $input;

    public function __construct()
    {
        $this->input = new Input();
        $this->database = new \PDO(
            $this->input->getEnv('DSN'),
            $this->input->getEnv('DB_USER'),
            $this->input->getEnv('DB_PASSWORD'),
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            ]
        );
    }

    public function createQuery(string $sql, array $params = [])
    {
        if (!$params) {
            return $this->database->query($sql);
        }
        $result = $this->database->prepare($sql);
        $result->execute($params);

        return $result;
    }
}
