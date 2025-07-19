<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $query = Order::with('client', 'products');

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('phone')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->phone . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        return view('orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
            'filters' => $request->only(['id', 'phone', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))],
        ]);

        $newStatus = $request->input('status');
        if ($newStatus === OrderStatus::Delivered->value) {
            cache()->forget("order_{$order->id}");
            $order->delete();
            return redirect()->route('orders.index')->with('success', 'Pedido entregado y eliminado con éxito.');
        }

        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('orders.show', $order)->with('success', 'Estado actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
