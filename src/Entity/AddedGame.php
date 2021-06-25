<?php

namespace App\Entity;

use App\Repository\AddedGameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddedGameRepository::class)
 */
class AddedGame
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="addedGames")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Games::class)
     */
    private $game_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $added_game_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

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

    public function getAddedGameDate(): ?\DateTimeInterface
    {
        return $this->added_game_date;
    }

    public function setAddedGameDate(\DateTimeInterface $added_game_date): self
    {
        $this->added_game_date = $added_game_date;

        return $this;
    }
}
