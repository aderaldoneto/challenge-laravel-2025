<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categorías') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('categories.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                + Nueva Categoría
            </a>

            @if (session('success'))
                <div class="mt-4 text-green-600">{{ session('success') }}</div>
            @endif

            <ul class="mt-6 space-y-2">
                @foreach ($categories as $category)
                    <li class="flex justify-between items-center border-b pb-2">
                        <span>{{ $category->name }}</span>
                        <div>
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block ml-2"
                                  onsubmit="return confirm('¿Está seguro de que desea eliminar?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
