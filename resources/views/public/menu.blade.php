<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        @forelse ($menu->products as $product)
            <div class="bg-white shadow p-4 rounded mb-4">
                <h3 class="text-lg font-bold">{{ $product->name }}</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-blue-600 mt-2 font-semibold">
                    R$ {{ number_format($product->price / 100, 2, ',', '.') }}
                </p>
                <p class="text-sm text-gray-400">Categoria: {{ $product->category->name ?? 'N/A' }}</p>
            </div>
        @empty
            <p class="text-gray-500">Nenhum produto encontrado neste menu.</p>
        @endforelse
    </div>

    <div class="flex gap-4 items-center">
        <a href="{{ route('public.index') }}" class="text-black-600 hover:underline">
            Voltar
        </a>
    </div>
</x-guest-layout>
