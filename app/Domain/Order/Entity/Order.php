<?php

namespace App\Domain\Order\Entity;

use App\Domain\Order\ValueObject\OrderId;
use App\Domain\Order\ValueObject\PromoCode;

class Order
{
    private OrderId $id;
    private int $originalTotal;      // ← исходная сумма
    private int $finalTotal;          // ← сумма со скидкой (кэш)
    private string $status;
    private \DateTimeImmutable $createdAt;
    private ?PromoCode $promoCode;    // ← может быть null

    public function __construct(OrderId $id, int $total)
    {
        if ($total <= 0) {
            throw new \DomainException('Order total must be greater than 0');
        }

        $this->id = $id;
        $this->originalTotal = $total;
        $this->finalTotal = $total;   // пока без скидки
        $this->status = 'pending';
        $this->createdAt = new \DateTimeImmutable();
        $this->promoCode = null;
    }

    public function applyPromoCode(PromoCode $promoCode): void
    {
        if ($this->status !== 'pending') {
            throw new \DomainException('Cannot apply promo code to non-pending order');
        }

        $this->promoCode = $promoCode;
        $this->recalculateFinalTotal();
    }

    private function recalculateFinalTotal(): void
    {
        $discount = $this->promoCode?->getDiscountPercent() ?? 0;
        $this->finalTotal = (int)($this->originalTotal * (1 - $discount / 100));
    }
    public function getTotal(): int
    {
        return $this->finalTotal; // или $this->originalTotal
    }

    public function pay(): void
    {
        if ($this->status !== 'pending') {
            throw new \DomainException('Order already paid');
        }
        $this->status = 'paid';
    }

    public function cancel(): void
    {
        if ($this->status === 'paid') {
            throw new \DomainException('Cannot cancel paid order');
        }
        $this->status = 'cancelled';
    }

    // Геттеры
    public function getId(): OrderId
    {
        return $this->id;
    }

    public function getOriginalTotal(): int
    {
        return $this->originalTotal;
    }

    public function getFinalTotal(): int
    {
        return $this->finalTotal;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPromoCode(): ?PromoCode
    {
        return $this->promoCode;
    }
}
