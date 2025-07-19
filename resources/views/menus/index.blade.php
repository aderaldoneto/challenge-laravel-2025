<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menus') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('menus.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
                Criar Menu
            </a>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <ul>
                    @foreach ($menus as $menu)
                        <li class="mb-2">
                            <a href="{{ route('menus.show', $menu) }}" class="text-blue-600 hover:underline">
                                {{ $menu->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
