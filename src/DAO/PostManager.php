<?php

namespace App\DAO;


use App\Model\Post;

class PostManager extends DAO
{

    public function findAll(): array
    {
    /*   if (isset($_SESSION['newsession'])){
            $idSession = (array)$_SESSION['newsession'];
            $arrayIdSession =(array)$idSession['id'];
            var_dump($arrayIdSession);
        }
*/
        $result = $this->createQuery('SELECT * FROM post');
        $posts =[];
        foreach ($result->fetchAll() as $post){
            $posts[]= $this->buildObject($post);
        }
        {
      //  $posts = array_merge($arrayIdSession,$posts);
        var_dump($posts);
        return $posts;
    }

    }

    public function find($postId): ? Post
    {
        $result = $this->createQuery('SELECT * FROM post WHERE id = ?', [$postId]);
        if (false === $object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    public function findPostsByUsername()
    {
        $result = $this->createQuery('SELECT * FROM post');
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

    public function create(Post $post)
    {
        $idSession = (array)$_SESSION['newsession'];
        $arrayIdSession =(array)$idSession['id'];
        var_dump($arrayIdSession);
        $this->createQuery(
            'INSERT INTO post (title, content,user_id)VALUES(?,?,?)  ',
       $result= array_merge($this->buildValues($post),$arrayIdSession));

        var_dump($result);
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
            //$post->getUserId(),
            $post->getTitle(),
            $post->getContent(),
        ];
    }

    private function buildObject(object $post):Post
    {
        return (new Post())
            //->setUserId($post->userId)
            ->setTitle($post->title)
            ->setContent($post->content)
            ->setCreatedAt(new \DateTimeImmutable($post->createdAt));
            return $post;
    }


}