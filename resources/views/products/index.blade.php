<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('products.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                + Novo Produto
            </a>

            @if (session('success'))
                <div class="mt-4 text-green-600">{{ session('success') }}</div>
            @endif

            <table class="w-full mt-6 table-auto border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Nome</th>
                        <th class="p-2 border">Categoria</th>
                        <th class="p-2 border">Preço</th>
                        <th class="p-2 border">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="text-center">
                            <td class="p-2 border">{{ $product->name }}</td>
                            <td class="p-2 border">{{ $product->category->name ?? '-' }}</td>
                            <td class="p-2 border">R$ {{ number_format($product->price / 100, 2, ',', '.') }}</td>
                            <td class="p-2 border">
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">Editar</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block ml-2"
                                      onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
