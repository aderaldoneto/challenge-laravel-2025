<x-guest-layout>
    <x-public.header :title="'Carrinho'" />
    
    <div class="py-6">
        @if (session('success'))
            <div class="mt-4 text-green-600">{{ session('success') }}</div>
        @endif
        <br />
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Cardápio
        </h2>

        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="col-span-1 sm:col-span-2 md:col-span-3">
            </div>
            @foreach ($menus as $menu)
                <a href="{{ route('public.menu', $menu->slug) }}" class="block bg-white dark:bg-gray-800 p-4 rounded shadow hover:shadow-md transition">
                    <h3 class="text-lg font-semibold">{{ $menu->name }}</h3>
                </a>
            @endforeach
        </div>

        <br />

        <form method="GET" action="{{ route('public.order.details') }}" class="mb-6 max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-3">
                <button class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                    Buscar
                </button>
            </div>
        </form>

    </div>
</x-guest-layout>
