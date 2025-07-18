<x-guest-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Cardápio
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($menus as $menu)
                <a href="{{ route('public.menu', $menu->slug) }}" class="block bg-white dark:bg-gray-800 p-4 rounded shadow hover:shadow-md transition">
                    <h3 class="text-lg font-semibold">{{ $menu->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</x-guest-layout>
