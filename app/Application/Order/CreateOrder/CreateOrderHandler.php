<?php

namespace App\Application\Order\CreateOrder;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Repository\OrderRepositoryInterface;
use App\Domain\Order\ValueObject\OrderId;

class CreateOrderHandler
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository
    ) {}
    
    public function execute(CreateOrderCommand $command): void
    {
        $orderId = new OrderId($command->orderId);
        
        if ($this->orderRepository->exists($orderId)) {
            throw new \DomainException('Order already exists');
        }
        
        $order = new Order($orderId, $command->total);
        $this->orderRepository->save($order);
    }
}
