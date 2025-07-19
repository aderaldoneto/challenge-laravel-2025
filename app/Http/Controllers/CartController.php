<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $productIds = array_keys($cart);

        $products = Product::whereIn('id', $productIds)->get();

        $items = $products->map(function ($product) use ($cart) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cart[$product->id],
                'total' => $product->price * $cart[$product->id],
            ];
        });

        $total = $items->sum('total');

        return view('public.cart', [
            'items' => $items,
            'total' => $total,
        ]);
    }


    public function add(Product $product)
    {
        $cart = session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
        session(['cart' => $cart]);

        return back();
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]--;

            if ($cart[$product->id] <= 0) {
                unset($cart[$product->id]);
            }

            session(['cart' => $cart]);
        }

        return back();
    }

    public function form()
    {
        $cart = session('cart', []);
        $productIds = array_keys($cart);

        $products = Product::whereIn('id', $productIds)->get();

        $items = $products->map(function ($product) use ($cart) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cart[$product->id],
                'total' => $product->price * $cart[$product->id],
            ];
        });

        $total = $items->sum('total');

        return view('public.checkout', [
            'items' => $items,
            'total' => $total,
        ]);
    }


    public function submit(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('checkout.form')->with('error', 'El carrito está vacío.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        DB::beginTransaction();

        try {
            $client = Client::firstOrCreate([
                'phone' => $validated['phone'],
            ], [
                'name' => $validated['name'],
                'address' => $validated['address'],
            ]);

            $total = 0;
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                $total += (int) $product->price * $quantity;
            }

            $order = Order::create([
                'client_id' => $client->id,
                'status' => OrderStatus::Pending,
                'total' => $total,
            ]);

            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);

                if ($product) {
                    $order->products()->attach($productId, [
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }
            }

            DB::commit();
            session()->forget('cart');
            return redirect()->route('public.index')->with('success', '¡Pedido realizado con éxito! ID: #'. $order->id);

        } catch (\Throwable $e) {

            DB::rollBack();
            \Log::error('Error al finalizar el pedido: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('checkout.form')->withErrors('Error al finalizar el pedido. Inténtalo de nuevo.');

        }
    }


}
