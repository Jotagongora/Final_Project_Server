<?php

namespace App\Entity;

use App\Repository\GamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GamesRepository::class)
 */
class Games
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
     * @ORM\Column(type="string", length=255)
     */
    private $game_img;

    /**
     * @ORM\Column(type="datetime")
     */
    private $release_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="game_id")
     */
    private $posts_game;

    public function __construct()
    {
        $this->posts_game = new ArrayCollection();
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

    public function getUrl(string $game_img): ?string
    {
        return "http://localhost:8000/game/".$game_img;
    }

    public function getGameImg(): ?string
    {
       return $this->game_img;
        
    }

    public function getGameUrl(): ?string
    {
       return $this->getUrl($this->getGameImg());
        
    }

    public function setGameImg(string $game_img): self
    {
        $this->game_img = $game_img;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostsGame(): Collection
    {
        return $this->posts_game;
    }

    public function addPostsGame(Post $postsGame): self
    {
        if (!$this->posts_game->contains($postsGame)) {
            $this->posts_game[] = $postsGame;
            $postsGame->setGameId($this);
        }

        return $this;
    }

    public function removePostsGame(Post $postsGame): self
    {
        if ($this->posts_game->removeElement($postsGame)) {
            // set the owning side to null (unless already changed)
            if ($postsGame->getGameId() === $this) {
                $postsGame->setGameId(null);
            }
        }

        return $this;
    }
}
