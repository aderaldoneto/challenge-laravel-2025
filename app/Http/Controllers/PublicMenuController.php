<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicMenuController extends Controller
{

    public function index()
    {
        $menus = Menu::all();
        return view('public.index', compact('menus'));
    }

    public function show(string $slug): View
    {
        $menu = Menu::where('slug', $slug)->with('products.category')->firstOrFail();

        return view('public.menu', compact('menu'));
    }

    
}
