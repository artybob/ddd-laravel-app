<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\Repository\OrderRepositoryInterface;
use App\Domain\Order\ValueObject\OrderId;

class OrderRepository implements OrderRepositoryInterface
{
    public function save(Order $order): void
    {
        OrderModel::updateOrCreate(
            ['id' => $order->getId()->value()],
            [
                'total' => $order->getTotal(),
                'status' => $order->getStatus(),
            ]
        );
    }
    
    public function findById(OrderId $id): ?Order
    {
        $model = OrderModel::find($id->value());
        if (!$model) {
            return null;
        }
        
        return new Order($id, (int) $model->total);
    }
    
    public function exists(OrderId $id): bool
    {
        return OrderModel::where('id', $id->value())->exists();
    }
}
