<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content_text;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     */
    private $author_id;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="post_comments")
     */
    private $post_id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentText(): ?string
    {
        return $this->content_text;
    }

    public function setContentText(?string $content_text): self
    {
        $this->content_text = $content_text;

        return $this;
    }

    public function getAuthorId(): ?User
    {
        return $this->author_id;
    }

    public function setAuthorId(?User $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getPostId(): ?Post
    {
        return $this->post_id;
    }

    public function setPostId(?Post $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
