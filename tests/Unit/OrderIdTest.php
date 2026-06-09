<?php

namespace Tests\Unit;

use App\Domain\Order\ValueObject\OrderId;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class OrderIdTest extends TestCase
{
    public function test_valid_order_id_creates_object(): void
    {
        $orderId = new OrderId('ORD-00001');
        $this->assertSame('ORD-00001', $orderId->value());
    }

    public function test_invalid_format_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new OrderId('INVALID');
    }

    public function test_two_equal_order_ids_are_equal(): void
    {
        $id1 = new OrderId('ORD-00123');
        $id2 = new OrderId('ORD-00123');
        $this->assertTrue($id1->equals($id2));
    }

    public function test_two_different_order_ids_are_not_equal(): void
    {
        $id1 = new OrderId('ORD-00123');
        $id2 = new OrderId('ORD-00999');
        $this->assertFalse($id1->equals($id2));
    }
}
