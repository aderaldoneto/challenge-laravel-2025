<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Menú
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('menus.update', $menu) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block">Nombre</label>
                    <input name="name" value="{{ old('name', $menu->name) }}" class="w-full border rounded p-2" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Productos</label>
                    <select name="products[]" multiple class="w-full border rounded p-2">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"
                                @selected(in_array($product->id, old('products', $selectedProducts ?? [])))>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="flex gap-4 items-center">
                    <a href="{{ route('menus.show', $menu->id) }}" class="bg-yellow-400 px-4 py-2 rounded hover:bg-yellow-500">
                        Volver
                    </a>
                    <button class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                        Actualizar
                    </button>

                    <a href="{{ route('menus.index') }}" class="text-black-600 hover:underline">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
