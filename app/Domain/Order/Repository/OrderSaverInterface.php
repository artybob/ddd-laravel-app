<?php

namespace App\Domain\Order\Repository;

use App\Domain\Order\Entity\Order;

interface OrderSaverInterface
{
    public function save(Order $order): void;
}
