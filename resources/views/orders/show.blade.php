<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Pedido #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto space-y-6">
        <div class="bg-white p-4 shadow rounded">
            <p><strong>Cliente:</strong> {{ $order->client->name }}</p>
            <p><strong>Dirección:</strong> {{ $order->client->address }}</p>
            <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> S/ {{ number_format($order->total / 100, 2, ',', '.') }}</p>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-bold mb-2">Productos:</h3>
            <ul class="list-disc list-inside">
                @foreach ($order->products as $product)
                    <li>
                        {{ $product->name }} ({{ $product->pivot->quantity }}x) - 
                        S/ {{ number_format(($product->pivot->price * $product->pivot->quantity) / 100, 2, ',', '.') }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <form method="POST" action="{{ route('orders.update', $order) }}">
                @csrf
                @method('PUT')

                <label class="block mb-2 font-semibold">Status do Pedido:</label>
                <select name="status" class="border p-2 rounded w-full mb-4">
                    @foreach (\App\Enums\OrderStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>

                <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                    Actualizar Status
                </button>
            </form>
        </div>
        <div class="flex gap-4 items-center">
            <a href="{{ route('orders.index') }}" class="text-black-600 hover:underline">
                Volver
            </a>
        </div>
    </div>
</x-app-layout>
