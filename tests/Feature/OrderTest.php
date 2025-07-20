<?php

use App\Models\Client;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

use function Pest\Laravel\post;
use function Pest\Laravel\withSession;
use function Pest\Laravel\assertDatabaseHas;

test('user can create order with products', function () {
    $client = Client::factory()->create();
    $products = Product::factory()->count(2)->create();

    $cart = [
        $products[0]->id => 2,
        $products[1]->id => 1,
    ];

    withSession(['cart' => $cart]);

    $response = post(route('checkout.submit'), [
        'name' => $client->name,
        'phone' => $client->phone,
        'address' => $client->address,
    ]);

    $response->assertRedirect(route('public.index'));

    assertDatabaseHas('orders', [
        'client_id' => $client->id,
        'status' => 'initiated',
    ]);

    $order = Order::where('client_id', $client->id)->latest()->first();
    expect($order)->not->toBeNull();
    expect($order->products)->toHaveCount(2);

    foreach ($cart as $productId => $quantity) {
        assertDatabaseHas('order_product', [
            'order_id' => $order->id,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }
});
