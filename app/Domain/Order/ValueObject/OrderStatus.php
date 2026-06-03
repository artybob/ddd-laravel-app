<?php

namespace App\Domain\Order\ValueObject;

final class OrderStatus
{
    private string $status;

    private const STATUSES = ['pending', 'paid', 'shipped', 'cancelled'];

    public function __construct(string $status)
    {
        if (! in_array($status, self::STATUSES)) {
            throw new \InvalidArgumentException('Invalid status. Allowed: '.implode(', ', self::STATUSES));
        }
        $this->status = $status;
    }

    public function value(): string
    {
        return $this->status;
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
