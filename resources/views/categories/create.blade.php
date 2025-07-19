<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nueva Categoría') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block font-medium">Nombre</label>
                    <input type="text" name="name" id="name" class="w-full border rounded p-2" value="{{ old('name') }}" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-4 items-center">
                    <a href="{{ route('categories.index') }}" class="text-black-600 hover:underline">
                        Volver
                    </a>
                    <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                        Guardar
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
