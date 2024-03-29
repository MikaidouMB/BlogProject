<?php
namespace App\DAO;

use App\Model\Post;
use App\Session;

class PostManager extends DAO
{
    private Session $session;

    public function __construct()
    {
        $this->session = new Session();
        parent::__construct();

    }

    /**
     * @return array
     * @throws \Exception
     */
    public function findAll(): array
    {
        $result = $this->createQuery('SELECT * FROM post ORDER BY modifiedOn DESC');
        $posts = [];
        foreach ($result->fetchAll() as $post) {
            $posts[]= $this->buildObject($post);
        }
        return $posts;
    }

    /**
     * @param $postId
     * @return Post|null
     * @throws \Exception
     */
    public function find($postId): ?Post
    {
        $result = $this->createQuery('SELECT * FROM post WHERE post.id = ?', [$postId]);
        if (false === $object = $result->fetchObject()) {
            return null;
        }
        return $this->buildObject($object);
    }

    /**
     * @param $sessionUserId
     * @return array
     * @throws \Exception
     */
    public function findPostFromUserId($sessionUserId): array
    {
        $result = $this->createQuery('SELECT * FROM post WHERE post.user_id = ?', [$sessionUserId]);
        $posts = [];
        foreach ($result->fetchAll() as $post) {
            $posts[]= $this->buildObject($post);
        }
        return $posts;
    }

    /**
     * @param Post|null $post
     * @return bool
     */
    public function updateAdminPost(?Post $post): bool
    {
        $result = $this->createQuery(
            'UPDATE post SET  author = ?, title = ?, user_id = ?, content = ? WHERE id = ?',
            array_merge($this->buildValues($post), [$post->getPostId()])
        );
        return 1<= $result->rowCount();
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function create(Post $post)
    {
        $this->createQuery(
            'INSERT INTO post (author,title,user_id,content)VALUES(?,?,?,?) ',
            $result= array_merge($this->buildValues($post))
        );
        return $result;
    }

    /**
     * @param $postId
     * @return bool
     */
    public function delete($postId): bool
    {
        $result = $this->createQuery(
            'DELETE FROM post WHERE id = ?',
            [$postId],
        );
        return 1<= $result->rowCount();
    }

    /**
     * @param Post $post
     * @return array
     */
    private function buildValues(Post $post): array
    {
        return [
            $post->getAuthor(),
            $post->getTitle(),
            $post->getUserId(),
            $post->getContent(),
        ];
    }

    /**
     * @param object $post
     * @return Post
     * @throws \Exception
     */
    private function buildObject(object $post): Post
    {
        return (new Post())
            ->setPostId($post->id)
            ->setUserId($post->user_id)
            ->setAuthor($post->author)
            ->setTitle($post->title)
            ->setContent($post->content)
            ->setModifiedOn(new \DateTimeImmutable($post->modifiedOn));
    }
}