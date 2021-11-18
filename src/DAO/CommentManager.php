<?php

namespace App\DAO;

use App\Model\Comment;

class CommentManager extends DAO
{
    /**
     * @param \App\Model\Comment $comment
     * @return mixed
     */
    public function createComment(Comment $comment)
    {
        $this->createQuery(
            'INSERT INTO comment (id ,user_id, postId, username, content, is_valid)VALUES(?,?,?,?,?,?) ',
            $result = array_merge($this->buildValues($comment)));
        return $result;
    }

    /**
     * @param \App\Model\Comment $comment
     * @return bool
     */
    public function update(Comment $comment): bool
    {
        $result = $this->createQuery(
            'UPDATE comment SET id = ?, user_id = ? ,postId = ?, username = ?,  content = ? , is_valid = ? WHERE id = ?',
            array_merge($this->buildValues($comment), [$comment->getId()])
        );
        return 1<= $result->rowCount();
    }

    /**
     * @param $commentId
     * @return \App\Model\Comment|null
     * @throws \Exception
     */
    public function find($commentId): ? Comment
    {
        $result = $this->createQuery('SELECT * FROM comment WHERE comment.id = ?', [$commentId]);
        if (false === $object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    /**
     * @param $postId
     * @return array
     */
    public function findCommentsByPostId($postId): array
    {
        $result = $this->createQuery('SELECT * FROM comment WHERE comment.postId = ? ORDER BY modifiedOn DESC  ', $postId);
        return $result->fetchAll();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function findAllComments(): array
    {
        $result = $this->createQuery('SELECT * FROM comment ORDER BY modifiedOn DESC ');
        $comments = [];
        foreach ($result->fetchAll() as $comment){
            $comments[]= $this->buildObject($comment);
        }
        return $comments;
    }

    /**
     * @param $commentId
     * @return bool
     */
    public function deleteAdminPostcomments($commentId): bool
    {
        $result = $this->createQuery(
            'DELETE FROM comment WHERE id = ?',[$commentId],
        );
        return 1<= $result->rowCount();
    }

    /**
     * @param \App\Model\Comment $comment
     * @return array
     */
    private function buildValues(Comment $comment): array
    {
        return[
            $comment->getId(),
            $comment->getUserId(),
            $comment->getPostId(),
            $comment->getUsername(),
            $comment->getContent(),
            $comment->getIsValid()
        ];
    }

    /**
     * @param object $comment
     * @return \App\Model\Comment
     * @throws \Exception
     */
    private function buildObject(object $comment):Comment
    {
        return (new Comment())
            ->setId($comment->id)
            ->setUserId($comment->user_id)
            ->setUsername($comment->username)
            ->setPostId($comment->postId)
            ->setContent($comment->content)
            ->setIsValid($comment->is_valid)
            ->setModifiedOn(new \DateTimeImmutable($comment->modifiedOn));
    }

}