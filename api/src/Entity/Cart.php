<?php

namespace App\Entity;

use App\Entity\Shop\User;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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

    #[Groups('shop')]
    private ?string $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("shop")
     */
    private ?\DateTime $create_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("shop")
     */
    private ?\DateTime $update_at;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="cart", cascade={"persist", "remove"})
     * @Groups("shop")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", options={"default": 1})
     * @Groups("shop")
     */
    private bool $is_empty;

    /**
     * @ORM\OneToMany(targetEntity=ProductsCart::class, mappedBy="cart")
     * @Groups("shop")
     */
    private $productsCarts;

    public function __construct()
    {
        $this->create_at = new \DateTime();
        $this->update_at = new \DateTime();
        $this->productsCarts = new ArrayCollection();
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

    public function setUpdateAt(): self
    {
        $this->update_at = new \DateTime();
        return $this;
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        if (!$this->create_at) {
            $this->create_at = new \DateTime();
        }
        if ($this->is_empty) {
            $this->is_empty = false;
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

    public function isEmpty(): bool
    {
        return $this->is_empty;
    }

    public function setIsEmpty(bool $is_empty): self
    {
        $this->is_empty = $is_empty;

        return $this;
    }

    /**
     * @return Collection|ProductsCart[]
     */
    public function getProductsCarts(): Collection
    {
        return $this->productsCarts;
    }

    public function addProductsCart(ProductsCart $productsCart): self
    {
        if (!$this->productsCarts->contains($productsCart)) {
            $this->productsCarts[] = $productsCart;
            $productsCart->setCart($this);
        }

        return $this;
    }

    public function removeProductsCart(ProductsCart $productsCart): self
    {
        if ($this->productsCarts->removeElement($productsCart)) {
            // set the owning side to null (unless already changed)
            if ($productsCart->getCart() === $this) {
                $productsCart->setCart(null);
            }
        }

        return $this;
    }

    public function showCart(): self
    {
        $productDetail = $this->getProductsCarts();
        $cartPrice = '0';
        foreach ($productDetail as $product) {
            $price = bcmul($product->getProduct()->getPrice(),  (string)$product->getCount(), 2);
            $product->setPrice($price);
            $cartPrice = bcadd($cartPrice, $price, 2);
        }
        $this->setPrice($cartPrice);
        return $this;
    }
}
