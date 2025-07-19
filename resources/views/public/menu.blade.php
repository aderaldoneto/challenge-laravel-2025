<x-guest-layout>
    <x-public.header :title="$menu->name" />

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        @php
            $cart = session('cart', []);
        @endphp

        @forelse ($menu->products as $product)
            <div class="bg-white shadow p-4 rounded mb-4">
                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-blue-600 mt-2 font-semibold">
                    S/ {{ number_format($product->price / 100, 2, ',', '.') }}
                </p>
                <p class="text-sm text-gray-400">Categoría: {{ $product->category->name ?? 'N/A' }}</p>

                @php
                    $quantity = $cart[$product->id] ?? 0;
                @endphp

                <div class="flex items-center mt-3 gap-2">
                    <form action="{{ route('cart.remove', $product) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-black px-3 py-1 rounded disabled:opacity-50"
                            {{ $quantity <= 0 ? 'disabled' : '' }}>
                            −
                        </button>
                    </form>

                    <span class="font-semibold text-lg">{{ $quantity }}</span>

                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-black px-3 py-1 rounded">+</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Ningún producto encontrado en este menú.</p>
        @endforelse
    </div>

    <div class="flex gap-4 items-center mt-6 ml-4">
        <a href="{{ route('public.index') }}" class="text-black-600 hover:underline">
            Volver
        </a>
    </div>
</x-guest-layout>
