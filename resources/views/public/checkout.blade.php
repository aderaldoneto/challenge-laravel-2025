<x-guest-layout>
    <x-public.header :title="'Finalizar Pedido'" />

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Finalizar Pedido
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form method="POST" action="{{ route('checkout.submit') }}">
            @csrf

            <div class="mb-4">
                <label class="block">Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded p-2">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block">Teléfono</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full border rounded p-2">
                @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block">Dirección</label>
                <textarea name="address" class="w-full border rounded p-2" required>{{ old('address') }}</textarea>
                @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Productos en el carrito:</h3>

                @forelse ($items as $item)
                    <div class="flex items-center justify-between mb-3 border-b pb-2">
                        <div>
                            <div class="font-semibold">{{ $item['name'] }}</div>
                            <div class="text-gray-600 text-sm">
                                Cantidad: {{ $item['quantity'] }}<br>
                                Precio unitario: S/ {{ number_format($item['price'] / 100, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-blue-600 font-semibold">
                            S/ {{ number_format($item['total'] / 100, 2, ',', '.') }}
                        </div>
                        <input type="hidden" name="products[{{ $item['id'] }}]" value="{{ $item['quantity'] }}">
                    </div>
                @empty
                    <p class="text-gray-500">Tu carrito está vacío.</p>
                @endforelse
            </div>

            @if ($items->count())
                <div class="mb-6 text-right font-bold text-lg">
                    Total: S/ {{ number_format($total / 100, 2, ',', '.') }}
                </div>

                <button class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                    Enviar Pedido
                </button>
            @endif
        </form>
    </div>
</x-guest-layout>
