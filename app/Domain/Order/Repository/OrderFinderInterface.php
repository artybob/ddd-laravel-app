<?php

namespace App\Domain\Order\Repository;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\ValueObject\OrderId;

interface OrderFinderInterface
{
    public function findById(OrderId $id): ?Order;
    public function exists(OrderId $id): bool;
}
