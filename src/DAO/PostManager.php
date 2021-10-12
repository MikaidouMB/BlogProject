<?php

namespace App\DAO;


use App\Model\Post;

class PostManager extends DAO
{
    public function findAll() : array
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
        $result = $this->createQuery('SELECT * FROM post WHERE post.id = ?', [$postId]);
        if (false === $object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    public function update(Post $post): bool
    {
        $result = $this->createQuery(
            'UPDATE post SET content = ?, author = ?,user_id = ?, title = ? WHERE id = ?',
        array_merge($this->buildValues($post), [$post->getId()])
        );

        return 1<= $result->rowCount();
    }

    public function updateAdminPost(?Post $post):bool
    {
        $result = $this->createQuery(
            'UPDATE post SET content = ?, author = ?,user_id = ?, title = ? WHERE id = ?',
            array_merge($this->buildValues($post), [$post->getId()])
        );

        return 1<= $result->rowCount();
    }



    public function create(Post $post)
    {
        $this->createQuery(
            'INSERT INTO post (title, content,user_id,author)VALUES(?,?,?,?) ',
            $result= array_merge($this->buildValues($post)));
        return $result;
    }

    public function delete($postId): bool
    {
        $result = $this->createQuery(
            'DELETE FROM post WHERE id = ?',[$postId],
    );
        return 1<= $result->rowCount();
    }

    private function buildValues(Post $post): array
    {
        return[
            //$post->getId(),
            $post->getAuthor(),
            $post->getTitle(),
            $post->getUserId(),
            $post->getContent(),
        ];
    }

    private function buildObject(object $post):Post
    {
        return (new Post())
            ->setId($post->id)
            ->setUserId($post->user_id)
            ->setAuthor($post->author)
            ->setTitle($post->title)
            ->setContent($post->content)
            ->setCreatedAt(new \DateTimeImmutable($post->createdAt));
            return $post;

    }


}