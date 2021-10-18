<?php


namespace App\DAO;

use App\Model\Comment;
use App\Model\Post;

class CommentManager extends DAO
{
    public function createComment(Comment $comment)
    {
        $this->createQuery(
            'INSERT INTO comment (id ,user_id, postId, username, content, valid)VALUES(?,?,?,?,?,?) ',
            $result = array_merge($this->buildValues($comment)));
        return $result;
    }

    public function update(Comment $comment): bool
    {
        $result = $this->createQuery(
            'UPDATE comment SET id = ?, user_id = ? ,postId = ?, username = ?,  content = ? , valid = ?
                WHERE id = ?',
            array_merge($this->buildValues($comment), [$comment->getId()])
        );
        return 1<= $result->rowCount();
    }


    public function find($commentId): ? Comment
    {
        $result = $this->createQuery('SELECT * FROM comment WHERE comment.id = ?', [$commentId]);
        if (false === $object = $result->fetchObject()){
            return null;
        }
        return $this->buildObject($object);
    }

    public function findCommentsBypostId($postId): array
    {
        $result = $this->createQuery('SELECT * FROM comment WHERE comment.postId = ? ORDER BY modifiedOn DESC  ', $postId  );
        return $result->fetchAll();

    }

    public function findAllComments(): array
    {
        $result = $this->createQuery('SELECT * FROM comment ORDER BY modifiedOn DESC ');
        $comments =[];
        foreach ($result->fetchAll() as $comment){
            $comments[]= $this->buildObject($comment);
        }
        return $comments;
    }

    public function findCommentAuthorsByUserId($comment): array
    {
        $result = $this->createQuery('SELECT * from comment');
        $comments = [];
        foreach ($result->fetchAll() as $comment) {
            $comments[] = $this->buildObject($comment);
        }
        return $comments;
    }
    public function deleteAdminPostcomments($commentId): bool
    {
        $result = $this->createQuery(
            'DELETE FROM comment WHERE id = ?',[$commentId],
        );
        return 1<= $result->rowCount();
    }

    public function validAdminPostcomments($comment): bool
    {
        $result = $this->createQuery(
            'UPDATE user SET id = ?, username = ?, password = ?, role = ?, email = ?, valid = ?  WHERE id = ?',
            array_merge($this->buildValues($comment), [$comment->getId()])
        );
        return 1 <= $result->rowCount();
    }
    private function buildValues(Comment $comment): array
    {
        return[
            $comment->getId(),
            $comment->getUserId(),
            $comment->getPostId(),
            $comment->getUsername(),
            $comment->getContent(),
            $comment->getValid()
        ];
    }

    private function buildObject(object $comment):Comment
    {
        return (new Comment())
            ->setId($comment->id)
            ->setUserId($comment->user_id)
            ->setUsername($comment->username)
            ->setPostId($comment->postId)
            ->setContent($comment->content)
            ->setValid($comment->valid)
            ->setModifiedOn(new \DateTimeImmutable($comment->modifiedOn));
    }


}