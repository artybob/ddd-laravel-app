<?php

namespace Tests\Unit;

use App\Application\Order\CreateOrder\CreateOrderCommand;
use App\Application\Order\CreateOrder\CreateOrderHandler;
use App\Domain\Order\Entity\Order;
use App\Domain\Order\Repository\OrderRepositoryInterface;
use App\Domain\Order\Strategy\SimpleOrderStrategy;
use App\Domain\Order\ValueObject\OrderId;
use DomainException;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateOrderHandlerTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    private OrderRepositoryInterface $repository;
    private CreateOrderHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(OrderRepositoryInterface::class);
        $this->handler = new CreateOrderHandler($this->repository, new SimpleOrderStrategy());
    }

    public function test_order_created_successfully(): void
    {
        $command = new CreateOrderCommand('ORD-00001', 1500);

        $this->repository->shouldReceive('exists')
            ->once()
            ->with(Mockery::on(fn(OrderId $id) => $id->value() === 'ORD-00001'))
            ->andReturnFalse();

        $this->repository->shouldReceive('save')
            ->once()
            ->with(Mockery::type(Order::class));

        $this->handler->execute($command);
        $this->assertTrue(true);
    }

    public function test_duplicate_order_throws_exception(): void
    {
        $command = new CreateOrderCommand('ORD-00001', 1500);

        $this->repository->shouldReceive('exists')
            ->once()
            ->andReturnTrue();

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Order already exists');

        $this->handler->execute($command);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
