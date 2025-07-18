<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $products = Product::all();
        return view('menus.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:menus'],
            'products' => ['nullable', 'array'],
            'products.*' => ['exists:products,id'],
        ]);

        $menu = Menu::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
        ]);

        $menu->products()->sync($validated['products'] ?? []);

        return redirect()->route('menus.show', $menu)->with('success', 'Menu criado com sucesso.');
    }

    public function show(Menu $menu)
    {
        $menu->load('products');
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $products = Product::all();
        $menu->load('products');

        return view('menus.edit', compact('menu', 'products'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:menus,slug,' . $menu->id],
            'products' => ['nullable', 'array'],
            'products.*' => ['exists:products,id'],
        ]);

        $menu->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
        ]);

        $menu->products()->sync($validated['products'] ?? []);

        return redirect()->route('menus.show', $menu)->with('success', 'Menu atualizado com sucesso.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu excluído com sucesso.');
    }

}
