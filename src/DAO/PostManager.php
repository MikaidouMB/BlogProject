<?php

namespace App\DAO;


use App\Model\Post;

class PostManager extends DAO
{

    public function findAll(): array
    {
        return $this->createQuery('SELECT * FROM post')->fetchAll();
    }
    public function create(Post $post): bool
    {
        $sql = 'INSERT INTO post(title, content, seen_at)VALUES (?,?,?)';
        $this->createQuery(
            $sql,
            [
                $post->getTitle(),
                $post->getContent(),
                $post->getSeenAt()->format('Y-m-d H-i-s'),
            ]
        );
        return true;
    }
}