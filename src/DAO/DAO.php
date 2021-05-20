<?php


namespace App\DAO;


abstract class DAO
{
     private \PDO $database;
     public function __construct()
     {
        $this->database = new \PDO(
            $_ENV['DSN'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE =>\PDO::FETCH_OBJ,
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