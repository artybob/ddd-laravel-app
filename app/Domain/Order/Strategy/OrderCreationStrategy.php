<?php

namespace App\Domain\Order\Strategy;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\ValueObject\OrderId;

interface OrderCreationStrategy
{
    public function create(OrderId $id, int $total): Order;
}
