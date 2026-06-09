<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderCreationTest extends TestCase
{
    public function test_order_can_be_created(): void
    {
        $response = $this->postJson('/api/orders', [
            'order_id' => 'ORD-00001',
            'total' => 1500,
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Order created successfully']);

        $this->assertDatabaseHas('orders', [
            'id' => 'ORD-00001',
            'total' => 1500,
            'status' => 'pending',
        ]);
    }

    public function test_duplicate_order_returns_error(): void
    {
        $this->postJson('/api/orders', [
            'order_id' => 'ORD-00001',
            'total' => 1500,
        ]);

        $response = $this->postJson('/api/orders', [
            'order_id' => 'ORD-00001',
            'total' => 2000,
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'Order already exists']);
    }

    public function test_invalid_order_id_format_returns_error(): void
    {
        $response = $this->postJson('/api/orders', [
            'order_id' => 'INVALID',
            'total' => 1500,
        ]);

        $response->assertStatus(422); // Validation error
    }
}
