<?php

namespace Tests\Unit;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\ValueObject\OrderId;
use DomainException;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private OrderId $orderId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderId = new OrderId('ORD-00001');
    }

    public function test_order_can_be_created(): void
    {
        $order = new Order($this->orderId, 1500);
        $this->assertSame(1500, $order->getTotal());
        $this->assertSame('pending', $order->getStatus());
    }

    public function test_order_can_be_paid(): void
    {
        $order = new Order($this->orderId, 1500);
        $order->pay();
        $this->assertSame('paid', $order->getStatus());
    }

    public function test_order_total_must_be_positive(): void
    {
        $this->expectException(DomainException::class);
        new Order($this->orderId, 0);
    }

    public function test_cannot_pay_already_paid_order(): void
    {
        $order = new Order($this->orderId, 1500);
        $order->pay();
        $this->expectException(DomainException::class);
        $order->pay();
    }

    public function test_order_can_be_cancelled(): void
    {
        $order = new Order($this->orderId, 1500);
        $order->cancel();
        $this->assertSame('cancelled', $order->getStatus());
    }

    public function test_cannot_cancel_paid_order(): void
    {
        $order = new Order($this->orderId, 1500);
        $order->pay();
        $this->expectException(DomainException::class);
        $order->cancel();
    }
}
