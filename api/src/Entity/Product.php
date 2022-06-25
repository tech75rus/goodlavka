<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("shop")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"shop", "admin"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"shop", "admin"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     * @Groups({"shop", "admin"})
     */
    private ?string $price;

    /**
     * @ORM\Column(type="json", length=255, nullable=true)
     *  @Groups({"shop", "admin", "profile"})
     */
    private ?array $image = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?array
    {
        return $this->image;
    }

    public function setImage(?array $image): self
    {
        $this->image = $image;

        return $this;
    }
}
