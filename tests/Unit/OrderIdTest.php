<?php

namespace Tests\Unit;

use App\Domain\Order\ValueObject\OrderId;
use PHPUnit\Framework\TestCase;

class OrderIdTest extends TestCase
{
    public function test_valid_order_id_passes()
    {
        $orderId = new OrderId('ORD-00001');
        $this->assertEquals('ORD-00001', $orderId->value());
    }
    
    public function test_invalid_order_id_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        new OrderId('INVALID');
    }
}
