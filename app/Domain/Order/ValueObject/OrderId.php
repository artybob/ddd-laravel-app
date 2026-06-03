<?php

namespace App\Domain\Order\ValueObject;

final class OrderId
{
    private string $value;

    public function __construct(string $value)
    {
        if (! preg_match('/^ORD-\d{5}$/', $value)) {
            throw new \InvalidArgumentException('Invalid order ID format. Expected ORD-00000');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(OrderId $other): bool
    {
        return $this->value === $other->value;
    }
}
