<?php

namespace App\Application\Order\CreateOrder;

class CreateOrderCommand
{
    public function __construct(
        public readonly string $orderId,
        public readonly int $total
    ) {}
}
