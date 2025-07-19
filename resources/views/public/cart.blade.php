<x-guest-layout>
    <x-public.header :title="'Carrinho'" />

    <div class="py-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Resumen del Carrito</h2>

        @forelse ($items as $item)
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <div>
                    <h3 class="font-semibold">{{ $item['name'] }}</h3>
                    <p class="text-gray-600">
                        Cantidad: {{ $item['quantity'] }} <br>
                        Precio unitario: S/ {{ number_format($item['price'] / 100, 2, ',', '.') }}
                    </p>
                </div>
                <div class="font-semibold text-blue-600">
                    S/ {{ number_format($item['total'] / 100, 2, ',', '.') }}
                </div>
            </div>
        @empty
            <p class="text-gray-500">Tu carrito está vacío.</p>
        @endforelse

        <div class="mt-6 text-right font-bold text-xl">
            Total: S/ {{ number_format($total / 100, 2, ',', '.') }}
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">Volver</a>
            @if ($items->count())
                <a href="{{ route('checkout.form') }}"
                   class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">Finalizar Pedido</a>
            @endif
        </div>
    </div>
</x-guest-layout>
