<?php

namespace App\Entity;

use App\Repository\PaymentDetailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PaymentDetailRepository::class)
 */
class PaymentDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Payment::class, inversedBy="paymentDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_payment;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @Groups({"profile"})
     */
    private $id_product;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"shop", "profile"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"shop", "profile"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     * @Groups({"shop", "profile"})
     */
    private ?string $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"shop", "profile"})
     */
    private ?int $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPayment(): ?Payment
    {
        return $this->id_payment;
    }

    public function setIdPayment(?Payment $id_payment): self
    {
        $this->id_payment = $id_payment;

        return $this;
    }

    public function getIdProduct(): ?Product
    {
        return $this->id_product;
    }

    public function setIdProduct(?Product $id_product): self
    {
        $this->id_product = $id_product;

        return $this;
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

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
