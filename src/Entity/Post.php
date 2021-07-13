<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content_text;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $start_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     */
    private $author_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $post_image;

    /**
     * @ORM\ManyToOne(targetEntity=Games::class, inversedBy="posts_game")
     */
    private $game_id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class)
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post_id")
     */
    private $post_comments;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->post_comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->start_at;
    }

    public function setStartAt(?\DateTimeImmutable $start_at): self
    {
        $this->start_at = $start_at;

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

    public function getPostImage(): ?string
    {
        return $this->post_image;
    }

    public function setPostImage(?string $post_image): self
    {
        $this->post_image = $post_image;

        return $this;
    }

    public function getGameId(): ?Games
    {
        return $this->game_id;
    }

    public function setGameId(?Games $game_id): self
    {
        $this->game_id = $game_id;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        } else {
            $this->likes->removeElement($like);
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getPostComments(): Collection
    {
        return $this->post_comments;
    }

    public function addPostComment(Comment $postComment): self
    {
        if (!$this->post_comments->contains($postComment)) {
            $this->post_comments[] = $postComment;
            $postComment->setPostId($this);
        }

        return $this;
    }

    public function removePostComment(Comment $postComment): self
    {
        if ($this->post_comments->removeElement($postComment)) {
            // set the owning side to null (unless already changed)
            if ($postComment->getPostId() === $this) {
                $postComment->setPostId(null);
            }
        }

        return $this;
    }
}
