<?php

namespace Tests\Unit;

use App\Domain\Order\Entity\Order;
use App\Domain\Order\ValueObject\OrderId;
use App\Domain\Order\ValueObject\PromoCode;
use Tests\TestCase;

class PromoCodeTest extends TestCase
{
    public function test_black_friday_promo_code_applies_20_percent_discount(): void
    {
        $order = new Order(new OrderId('ORD-00001'), 1000);
        $promoCode = new PromoCode('BLACKFRIDAY');

        $order->applyPromoCode($promoCode);

        $this->assertSame(1000, $order->getOriginalTotal());
        $this->assertSame(800, $order->getFinalTotal());
        $this->assertSame('BLACKFRIDAY', $order->getPromoCode()->getCode());
    }

    public function test_invalid_promo_code_throws_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new PromoCode('INVALID');
    }
}
