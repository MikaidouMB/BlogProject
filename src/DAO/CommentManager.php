<?php


namespace App\DAO;

use App\Model\Comment;
use App\Model\Post;

class CommentManager extends DAO
{
    public function createComment(Comment $comment)
    {
        $idArray[] = ($_SESSION['newsession']->id);
        $this->createQuery(
            'INSERT INTO comment (content,user_id)VALUES(?,?) ',
            $result= array_merge($this->buildValues($comment),$idArray));
        return $result;
    }

    private function buildValues(Comment $comment): array
    {
        return[
            //$comment->getUserId(),
            $comment->getContent(),
        ];
    }

    private function buildObject(object $comment):Comment
    {
        return (new Comment())
            //->setUserId($comment->user_id)
            ->setContent($comment->content)
            ->setCreatedAt(new \DateTimeImmutable($comment->createdAt));
        return $comment;

    }

}