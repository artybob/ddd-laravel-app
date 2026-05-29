<?php

namespace App\Domain\Order\Strategy;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\ValueObject\OrderId;

class DiscountedOrderStrategy implements OrderCreationStrategy
{
    private int $discountPercent;
    
    public function __construct(int $discountPercent)
    {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new \InvalidArgumentException('Discount must be between 0 and 100');
        }
        $this->discountPercent = $discountPercent;
    }
    
    public function create(OrderId $id, int $total): Order
    {
        $order = new Order($id, $total);
        $order->applyDiscount($this->discountPercent);
        return $order;
    }
}
