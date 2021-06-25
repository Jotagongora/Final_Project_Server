<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     */
    private $source_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="target_messages")
     */
    private $target_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content_text;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSourceId(): ?User
    {
        return $this->source_id;
    }

    public function setSourceId(?User $source_id): self
    {
        $this->source_id = $source_id;

        return $this;
    }

    public function getTargetId(): ?User
    {
        return $this->target_id;
    }

    public function setTargetId(?User $target_id): self
    {
        $this->target_id = $target_id;

        return $this;
    }

    public function getContentText(): ?string
    {
        return $this->content_text;
    }

    public function setContentText(string $content_text): self
    {
        $this->content_text = $content_text;

        return $this;
    }
}
