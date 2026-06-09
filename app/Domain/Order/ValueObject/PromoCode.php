<?php

namespace App\Domain\Order\ValueObject;

final class PromoCode
{
    private string $code;
    private int $discountPercent;

    private const PROMOCODES = [
        'BLACKFRIDAY' => 20,
        'WELCOME10' => 10,
    ];

    public function __construct(string $code)
    {
        if (!isset(self::PROMOCODES[$code])) {
            throw new \InvalidArgumentException("Invalid promo code: {$code}");
        }

        $this->code = $code;
        $this->discountPercent = self::PROMOCODES[$code];
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }
}
