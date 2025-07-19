<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Produtos no menu:</h3>
                <ul class="list-disc pl-6">
                    @foreach ($menu->products as $product)
                        <li>{{ $product->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="mt-6 flex gap-4">
        <a href="{{ route('menus.index') }}" class="bg-yellow-400 px-4 py-2 rounded hover:bg-yellow-500">
            Voltar
        </a>
        <a href="{{ route('menus.edit', $menu) }}" class="bg-yellow-400 px-4 py-2 rounded hover:bg-yellow-500">Editar</a>

        <form method="POST" action="{{ route('menus.destroy', $menu) }}" onsubmit="return confirm('Tem certeza que deseja excluir este menu?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-600">Excluir</button>
        </form>
    </div>

</x-app-layout>
