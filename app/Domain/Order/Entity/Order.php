<?php

namespace App\Domain\Order\Entity;

use App\Domain\Order\ValueObject\OrderId;

class Order
{
    private OrderId $id;
    private int $total;
    private string $status;
    private \DateTimeImmutable $createdAt;
    
    public function __construct(OrderId $id, int $total)
    {
        if ($total <= 0) {
            throw new \DomainException('Order total must be greater than 0');
        }
        
        $this->id = $id;
        $this->total = $total;
        $this->status = 'pending';
        $this->createdAt = new \DateTimeImmutable();
    }
    
    public function getId(): OrderId
    {
        return $this->id;
    }
    
    public function getTotal(): int
    {
        return $this->total;
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    
    public function applyDiscount(int $percent): void
    {
        if ($percent < 0 || $percent > 100) {
            throw new \DomainException('Discount must be between 0 and 100');
        }
        $this->total = (int)($this->total * (1 - $percent / 100));
    }
}
