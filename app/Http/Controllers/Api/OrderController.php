<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Cache::remember('orders.active', 30, function () {
            return Order::with('products')
                ->where('status', '!=', OrderStatus::Delivered)
                ->get();
        });

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_address' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $client = Client::firstOrCreate([
                'name' => $data['client_name'],
                'phone' => $data['client_phone'],
                'address' => $data['client_address'],
            ]);

            $order = Order::create([
                'client_id' => $client->id,
                'status' => OrderStatus::Initiated->value,
                'total' => 0,
            ]);

            $total = 0;

            $category = Category::firstOrCreate(['name' => 'Carnes']);

            foreach ($data['items'] as $item) {
                $product = Product::firstOrCreate(
                    ['name' => $item['description']], 
                    ['category_id' => $category->id],
                );

                $order->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'price' => $item['unit_price'],
                ]);

                $total += $item['quantity'] * $item['unit_price'];
            }

            $order->update(['total' => $total]);

            Cache::forget('orders.active');

            DB::commit();

            return response()->json($order->load('products'), 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Error al crear el pedido: ' . $e->getMessage(), [
                'request' => $request->all(),
            ]);
            return response()->json(['error' => 'Error al crear el pedido'], 500);
        }
    }

    public function advance(Order $order)
    {
        $order = Order::findOrFail($order->id);
        if (! $order) {
            return response()->json(['message' => 'Pedido no encontrado'], 400);
        }

        $next = OrderStatus::next($order->status);

        if ($next === OrderStatus::Delivered) {
            $order->delete();
            Cache::forget('orders.active');

            return response()->json(['message' => 'Pedido entregado y eliminado con éxito']);
        }

        $order->update(['status' => $next]);

        Cache::forget('orders.active');

        return response()->json(['message' => 'Estado actualizado con éxito', 'status' => $next]);
    }

    public function show(Order $order)
    {
        return response()->json($order->load('products'));
    }
}
