<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PublicMenuController extends Controller
{

    public function index(Request $request)
    {
        $menus = Cache::remember('public_menus', 3600, function () {
            return Menu::with('products.category')->get();
        });

        return view('public.menu', compact('menus'));
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

    public function update(Request $request, Menu $menu)
    {
        Cache::forget('public_menus');

        return redirect()->route('menus.index')->with('success', 'Menu atualizado com sucesso.');
    }



    
}
