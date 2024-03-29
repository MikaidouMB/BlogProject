<?php
namespace App\Model;

class Post
{
    private ?int $postId = null;
    private int $userId;
    private string $author;
    private string $title;
    private string $content;
    private \DateTimeImmutable  $modifiedOn;

    public function __construct()
    {
        $this->modifiedOn = new \DateTimeImmutable();
    }

    /**
     * @return  integer
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param integer $postId
     * @return Post
     */
    public function setPostId(int $postId): Post
    {
        $this->postId = $postId;
        return $this;
    }

    /**
     * @return integer
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param integer $userId
     * @return Post
     */
    public function setUserId(int $userId): Post
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
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
     * @return Post
     */
    public function setContent(string $content): Post
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getModifiedOn(): \DateTimeImmutable
    {
        return $this->modifiedOn;
    }

    /**
     * @param \DateTimeImmutable $modifiedOn
     * @return Post
     */
    public function setModifiedOn(\DateTimeImmutable $modifiedOn): Post
    {
        $this->modifiedOn = $modifiedOn;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Post
     */
    public function setAuthor(string $author): Post
    {
        $this->author = $author;
        return $this;
    }
}