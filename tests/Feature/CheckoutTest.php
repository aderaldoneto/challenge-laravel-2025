<?php

use App\Models\Product;

test('order form requires name, phone and address', function () {
    $product = Product::factory()->create();

    $response = $this
        ->withSession([
            'cart' => [
                $product->id => [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                ],
            ],
        ])
        ->from(route('checkout.form'))
        ->post(route('checkout.submit'), []);

    $response->assertRedirect(route('checkout.form'));
    $response->assertSessionHasErrors(['name', 'phone', 'address']);
});

test('user cannot checkout with empty cart', function () {
    $response = $this
        ->from(route('checkout.form'))
        ->post(route('checkout.submit'), [
            'name' => 'Maria',
            'phone' => '11999999999',
            'address' => 'Rua B',
        ]);

    $response->assertRedirect(route('checkout.form'));
    $response->assertSessionHas('error', 'O carrinho está vazio.');
});
