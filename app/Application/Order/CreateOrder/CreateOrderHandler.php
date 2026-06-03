<?php

namespace App\Application\Order\CreateOrder;

use App\Domain\Order\Repository\OrderRepositoryInterface;
use App\Domain\Order\Strategy\OrderCreationStrategy;
use App\Domain\Order\ValueObject\OrderId;

class CreateOrderHandler
{
    public function __construct(
        private OrderRepositoryInterface $repository,
        private OrderCreationStrategy $strategy
    ) {}

    public function execute(CreateOrderCommand $command): void
    {
        $orderId = new OrderId($command->orderId);

        if ($this->repository->exists($orderId)) {
            throw new \DomainException('Order already exists');
        }

        $order = $this->strategy->create($orderId, $command->total);
        $this->repository->save($order);
    }
}
