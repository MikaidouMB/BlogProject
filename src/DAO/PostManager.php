<?php

namespace App\DAO;


use App\Model\Post;

class PostManager extends DAO
{

    public function findAll(): array
    {
        $result = $this->createQuery('SELECT * FROM post');

        $posts =[];
        foreach ($result->fetchAll() as $post){
            $posts[]= $this->buildObject($post);
        }
        return $posts;
    }

    public function find($postId): ? Post
    {
        $result = $this->createQuery('SELECT * FROM post WHERE id = ?', [$postId]);
        if (false === $object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    public function update(Post $post): bool
    {
        $result = $this->createQuery(
            'UPDATE post SET title = ?, content = ? WHERE id = ?',
        array_merge($this->buildValues($post), [$post->getId()])
        );

        return 1<= $result->rowCount();
    }

    public function create(Post $post): bool
    {
        $this->createQuery(
            'INSERT INTO post(title, content)VALUES(?,?)',
        $this->buildValues($post)
    );
        return true;
    }

    public function delete(Post $post): bool
    {
        $result = $this->createQuery(
            'DELETE FROM post WHERE id = ?',
            array_merge($this->buildValues($post), [$post->getId()])
    );
        return 1<= $result->rowCount();
    }

    private function buildValues(Post $post): array
    {
        return[
            $post->getTitle(),
            $post->getContent(),
        ];
    }

    private function buildObject(object $post):Post
    {
        return (new Post())
            ->setId($post->id)
            ->setTitle($post->title)
            ->setContent($post->content)
            ->setCreatedAt(new \DateTimeImmutable($post->createdAt));
            return $post;
    }
}