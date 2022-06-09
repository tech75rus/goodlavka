<?php

namespace App\Entity;

use App\Repository\ProductsCartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductsCartRepository::class)
 */
class ProductsCart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="productsCarts")
     */
    private $cart;

    /**
     * @ORM\Column(type="integer")
     * @Groups("shop")
     */
    private $count;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    #[Groups('shop')]
    private ?string $price = '0.00';

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     */
    #[Groups('shop')]
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count += $count;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = bcadd($this->price, $price, 2);

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
