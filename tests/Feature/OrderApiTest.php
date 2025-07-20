<?php

use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;

it('can create a new order', function () {
    $response = $this->postJson('/api/orders', [
        'client_name' => 'Carlos',
        'client_phone' => '123456789',
        'client_address' => '123 Main St',
        'items' => [
            ['description' => 'Pizza', 'quantity' => 2, 'unit_price' => 50],
        ],
    ]);

    $response->assertCreated()
             ->assertJsonStructure(['id', 'status', 'total', 'products']);
});

it('can list orders', function () {
    $response = $this->getJson('/api/orders');
    $response->assertOk()
             ->assertJsonIsArray();
});


it('can show order details', function () {
    $client = Client::factory()->create();

    $order = Order::factory()
        ->for($client)
        ->create();

    $product = Product::factory()->create();

    $order->products()->attach($product->id, [
        'quantity' => 1,
        'price' => 10,
    ]);

    $response = $this->getJson("/api/orders/{$order->id}");

    $response->assertOk()
             ->assertJsonStructure(['id', 'status', 'total', 'products']);
});


it('can advance an order status', function () {
    $client = Client::factory()->create();

    $order = Order::factory()->for($client)->create([
        'status' => OrderStatus::Initiated->value,
    ]);

    $response = $this->postJson("/api/orders/{$order->id}/advance");

    $response->assertOk()
             ->assertJsonStructure(['message', 'status']);

    $currentStatus = OrderStatus::from($order->status->value);
    $expectedNext = OrderStatus::next($currentStatus);

    expect($response->json('status'))->toBe($expectedNext->value); 
});