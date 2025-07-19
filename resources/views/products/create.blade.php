<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block">Nombre</label>
                    <input name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Descripción</label>
                    <textarea name="description" class="w-full border rounded p-2">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Precio</label>
                    <div class="flex rounded border overflow-hidden w-full max-w-xs">
                        <input
                            type="text"
                            name="price"
                            id="price"
                            class="w-40 p-2 border rounded"
                            required
                        >
                    </div>

                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block">Categoría</label>
                    <select name="category_id" class="w-full border rounded p-2" required>
                        <option value="">Seleccione</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-4 items-center">
                    <a href="{{ route('products.index') }}" class="text-black-600 hover:underline">
                        Volver
                    </a>
                    <button class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                        Guardar
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>

<script>
    const input = document.getElementById('price');

    input.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); 
        value = (Number(value) / 100).toFixed(2);
        value = value.replace('.', ','); 
        value = 'S/ ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
        e.target.value = value;
    });
</script>
