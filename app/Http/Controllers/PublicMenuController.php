<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicMenuController extends Controller
{

    public function index(Request $request)
    {
        $menus = Menu::all();

        $filters = $request->only(['id', 'phone', 'status']);

        return view('public.index', [
            'menus' => $menus,
            'filters' => $filters,
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function show(string $slug): View
    {
        $menu = Menu::where('slug', $slug)->with('products.category')->firstOrFail();

        return view('public.menu', compact('menu'));
    }

    public function checkout(string $slug): View
    {
        $menu = Menu::where('slug', $slug)->with('products')->firstOrFail();
        return view('public.checkout', compact('menu'));
    }

    public function details(Request $request)
    {
        $order = null;

        if ($request->filled('id')) {
            $order = Order::with('client', 'products')->find($request->id);
        }

        return view('public.order_details', [
            'order' => $order,
        ]);
    }


    
}
