<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Order\CreateOrder\CreateOrderCommand;
use App\Application\Order\CreateOrder\CreateOrderHandler;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function store(Request $request, CreateOrderHandler $handler)
    {
        $request->validate([
            'order_id' => 'required|string|regex:/^ORD-\d{5}$/',
            'total' => 'required|integer|min:1'
        ]);
        
        $command = new CreateOrderCommand(
            orderId: $request->input('order_id'),
            total: (int) $request->input('total')
        );
        
        try {
            $handler->execute($command);
            return response()->json(['message' => 'Order created successfully'], 201);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
