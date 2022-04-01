<?php

namespace App\Entity\Admin;

use App\Repository\Admin\AdminTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminTokenRepository::class)
 */
class AdminToken
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="adminTokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $AdminAdmin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $expiresAt;

    public function __construct()
    {
        $this->token = bin2hex(random_bytes(64));
        $this->expiresAt = new \DateTime('+5 hour');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdminAdmin(): ?Admin
    {
        return $this->AdminAdmin;
    }

    public function setAdminAdmin(?Admin $AdminAdmin): self
    {
        $this->AdminAdmin = $AdminAdmin;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt <= new \DateTime();
    }
}
