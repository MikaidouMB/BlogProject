<?php


namespace App\Model;


class Comment
{
    private int $id;
    private int $userId;
    private int $postId;
    private string $content;
    private \DateTimeImmutable  $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Comment
     */
    public function setId(int $id): Comment
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
 /*   public function getUserId(): int
    {
        return $this->userId;
    }
*/
    /**
     * @param int $userId
     * @return Comment
     */
 /*   public function setUserId(int $userId): Comment
    {
        $this->userId = $userId;
        return $this;
    }
*/
    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     * @return Comment
     */
    public function setPostId(int $postId): Comment
    {
        $this->postId = $postId;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Comment
     */
    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return Comment
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): Comment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}