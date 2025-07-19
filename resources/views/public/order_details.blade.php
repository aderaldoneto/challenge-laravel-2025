<x-guest-layout>
    <x-public.header :title="'Detalles del Pedido'" />

    <div class="py-6 max-w-4xl mx-auto">
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="id" placeholder="ID do Pedido" value="{{ request('id') }}" class="p-2 border rounded w-full">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Buscar</button>
        </form>

        @if ($order)
            <div class="bg-white shadow rounded p-4">
                <h2 class="text-lg font-bold mb-2">Pedido #{{ $order->id }}</h2>
                <p><strong>Cliente:</strong> {{ $order->client->name ?? 'Desconhecido' }}</p>
                <p><strong>Teléfono:</strong> {{ $order->client->phone ?? '-' }}</p>
                <p><strong>Estado:</strong> {{ $order->status->label() }}</p>
                <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                <h3 class="mt-4 font-semibold">Productos:</h3>
                <ul class="list-disc list-inside text-sm text-gray-700">
                    @foreach ($order->products as $product)
                        <li>{{ $product->name }} ({{ $product->pivot->quantity }}x) - 
                            S/ {{ number_format(($product->pivot->price * $product->pivot->quantity) / 100, 2, ',', '.') }}
                        </li>
                    @endforeach
                </ul>

                <div class="text-right font-bold mt-4">
                    Total: S/ {{ number_format($order->total / 100, 2, ',', '.') }}
                </div>
            </div>
        @elseif(request('id'))
            <p class="text-red-600">Pedido no encontrado.</p>
        @endif
    </div>

    <div class="flex gap-4 items-center">
        <a href="{{ route('public.index') }}" class="text-black-600 hover:underline">
            Volver
        </a>
    </div>
</x-guest-layout>
