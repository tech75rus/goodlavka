<?php

namespace App\Entity;

use App\Entity\Shop\User;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $create_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $update_at;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="cart", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_empty;

    public function __construct()
    {
        $this->create_at = new \DateTime();
        $this->update_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function createCart(): self
    {
        $this->create_at = new \DateTime();
        $this->update_at = new \DateTime();
        return $this;
    }

    public function clearCart(): self
    {
        $this->price = null;
        $this->create_at = null;
        $this->update_at = null;
        $this->is_empty = true;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        if (!$this->create_at) {
            $this->create_at = new \DateTime();
        }
        $this->update_at = new \DateTime();

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isEmpty(): ?bool
    {
        return $this->is_empty;
    }

    public function setIsEmpty(bool $is_empty): self
    {
        $this->is_empty = $is_empty;

        return $this;
    }
}
