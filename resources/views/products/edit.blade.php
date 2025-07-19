<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Produto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block">Nome</label>
                    <input name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Descrição</label>
                    <textarea name="description" class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Preço</label>
                    <div class="flex rounded border overflow-hidden w-full max-w-xs">
                        <input
                            type="text"
                            name="price"
                            id="price"
                            value="{{ old('price', $product->price) }}"
                            class="w-40 p-2 border rounded"
                            required
                        >
                    </div>

                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Categoria</label>
                    <select name="category_id" class="w-full border rounded p-2" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-4 items-center">
                    <a href="{{ route('products.index') }}" class="text-black-600 hover:underline">
                        Voltar
                    </a>
                    <button class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                        Atualizar
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>


<script>
    const input = document.getElementById('price');

    function formatCurrency(value) {
        value = value.toString().replace(/\D/g, '');
        value = (Number(value) / 100).toFixed(2);
        value = value.replace('.', ',');
        return 'R$ ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (input.value && !input.value.startsWith('R$')) {
            input.value = formatCurrency(input.value);
        }
    });

    input.addEventListener('input', function (e) {
        let cursorPosition = e.target.selectionStart;
        let rawValue = e.target.value.replace(/\D/g, '');
        e.target.value = formatCurrency(rawValue);
        e.target.setSelectionRange(cursorPosition, cursorPosition);
    });
</script>
