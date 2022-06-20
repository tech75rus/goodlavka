<?php

namespace App\Entity;

use App\Entity\Shop\User;
use App\Repository\PaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"shop", "profile"})
     */
    private ?string $id_yookassa;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"shop", "profile"})
     */
    private ?string $status;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     * @Groups({"shop", "profile"})
     */
    private ?string $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $at_create;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $at_update;

    /**
     * @ORM\OneToMany(targetEntity=PaymentDetail::class, mappedBy="id_payment", orphanRemoval=true)
     * @Groups({"shop", "profile"})
     */
    private $paymentDetails;

    public function __construct()
    {
        $this->paymentDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdYookassa(): ?string
    {
        return $this->id_yookassa;
    }

    public function setIdYookassa(string $id_yookassa): self
    {
        $this->id_yookassa = $id_yookassa;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getAtCreate(): ?\DateTimeInterface
    {
        return $this->at_create;
    }

    public function setAtCreate(\DateTimeInterface $at_create): self
    {
        $this->at_create = $at_create;

        return $this;
    }

    public function getAtUpdate(): ?\DateTimeInterface
    {
        return $this->at_update;
    }

    public function setAtUpdate(\DateTimeInterface $at_update): self
    {
        $this->at_update = $at_update;

        return $this;
    }

    /**
     * @return Collection<int, PaymentDetail>
     */
    public function getPaymentDetails(): Collection
    {
        return $this->paymentDetails;
    }

    public function addPaymentDetail(PaymentDetail $paymentDetail): self
    {
        if (!$this->paymentDetails->contains($paymentDetail)) {
            $this->paymentDetails[] = $paymentDetail;
            $paymentDetail->setIdPayment($this);
        }

        return $this;
    }

    public function removePaymentDetail(PaymentDetail $paymentDetail): self
    {
        if ($this->paymentDetails->removeElement($paymentDetail)) {
            // set the owning side to null (unless already changed)
            if ($paymentDetail->getIdPayment() === $this) {
                $paymentDetail->setIdPayment(null);
            }
        }

        return $this;
    }
}
