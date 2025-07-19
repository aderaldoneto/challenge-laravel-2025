<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Mis Pedidos
        </h2>
    </x-slot>

    <div class="bg-white p-4 rounded shadow mb-6">
        <form method="GET" action="{{ route('orders.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="phone" value="{{ $filters['phone'] ?? '' }}" class="mt-1 block w-full border rounded p-2" placeholder="Ex: 71999998888">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full border rounded p-2">
                    <option value="">-- Todos --</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" {{ ($filters['status'] ?? '') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 w-full">Filtrar</button>
            </div>
        </form>
    </div>


    <div class="py-6 max-w-4xl mx-auto">
        @if (session('success'))
                <div class="mt-4 text-green-600">{{ session('success') }}</div>
            @endif
        @forelse ($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="block hover:opacity-90 transition">
                <div class="bg-white shadow rounded p-4 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h3 class="text-lg font-bold">Pedido #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-500">
                                Cliente: {{ $order->client->name ?? 'Desconhecido' }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Realizado el {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-{{ $order->status->color() }}-200">
                            {{ $order->status->label() }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <h4 class="font-semibold">Productos:</h4>
                        <ul class="list-disc list-inside text-gray-700 text-sm">
                            @foreach ($order->products as $product)
                                <li>
                                    {{ $product->name }} ({{ $product->pivot->quantity }}x) - 
                                    S/ {{ number_format(($product->pivot->price * $product->pivot->quantity) / 100, 2, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="text-right font-bold">
                        Total: S/ {{ number_format($order->total / 100, 2, ',', '.') }}
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-500 text-center">Todavía no tienes ningún pedido.</p>
        @endforelse
    </div>
</x-app-layout>
