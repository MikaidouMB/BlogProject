<?php


namespace App\Model;


class Post
{
    private int $id;
    private string $title;
    private string $content;
    private \DateTimeImmutable $seenAt;

    public function __construct()
    {
        $this->seenAt = new \DateTimeImmutable();
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return Post
     */
    public function setId(int $id): Post
    {
        $this->id = $id;
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
    public function getSeenAt(): \DateTimeImmutable
    {
        return $this->seenAt;
    }

    /**
     * @param \DateTimeImmutable $seenAt
     * @return Post
     */
    public function setSeenAt(\DateTimeImmutable $seenAt): Post
    {
        $this->seenAt = $seenAt;
        return $this;
    }

}