<header class="bg-white dark:bg-gray-800 shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
        {{ $title ?? 'Cardápio' }}
    </h1>

    <a href="{{ route('cart.index') }}" class="relative inline-block" title="Ver carrinho">
        <svg class="w-6 h-6 text-gray-700 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="9" cy="21" r="1"/>
            <circle cx="20" cy="21" r="1"/>
        </svg>
        @php
            $cartCount = is_array(session('cart')) ? count(session('cart')) : 0;
        @endphp
        @if($cartCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-600 text-black text-xs rounded-full px-1">
                {{ $cartCount }}
            </span>
        @endif
    </a>
</header>
