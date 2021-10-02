<?php


namespace App\DAO;

use App\Model\Comment;
use App\Model\Post;

class CommentManager extends DAO
{
    public function createComment(Comment $comment)
    {
        $idArray[] = ($_SESSION['newsession']->id);
        $idPost [] = $comment->getPostId();
        $this->createQuery(
            'INSERT INTO comment (content,user_id,postId)VALUES(?,?,?) ',
            $result= array_merge($this->buildValues($comment),$idArray,$idPost));
        return $result;
    }

    //voir si cette fonction peut récupérer les userid et postId
    private function buildValues(Comment $comment): array
    {
        return[
            $comment->getContent(),
        ];
    }

    public function findAll() : array
    {
        $result = $this->createQuery('SELECT * FROM comment ');
        $comments =[];
        foreach ($result->fetchAll() as $comment){
            $comments[]= $this->buildObject($comment);
        }
        return $comments;
    }

    private function buildObject(object $comment):Comment
    {
        return (new Comment())
            ->setPostId($comment->postId)
            ->setUserId($comment->user_id)
            ->setContent($comment->content)
            ->setCreatedAt(new \DateTimeImmutable($comment->createdAt));
        return $comment;

    }

}