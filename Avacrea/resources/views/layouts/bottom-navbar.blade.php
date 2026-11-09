@php
    $currentRoute = Route::currentRouteName();
@endphp

<!-- Bottom Navbar -->
<nav class="h-20 shrink-0 bg-space-indigo px-8 flex items-center justify-around z-30 shadow-2xl border-t border-space-indigo">

    <!-- Home -->
    <a href="{{ route('dashboard') }}"
       class="flex flex-col items-center gap-1.5 {{ $currentRoute === 'dashboard' ? 'text-jasmine' : 'text-pearl-aqua/80 hover:text-pearl-aqua' }} group transition">

        <div class="w-11 h-11 rounded-2xl {{ $currentRoute === 'dashboard' ? 'bg-jasmine/20' : 'bg-transparent' }} flex items-center justify-center transition-transform group-hover:scale-110">
            <i class="fa-solid fa-house text-xl"></i>
        </div>

        <span class="text-xs {{ $currentRoute === 'dashboard' ? 'font-bold' : 'font-semibold' }} tracking-wider">
            Home
        </span>
    </a>


    <!-- Explore & Search -->
    <a href="{{ route('explore') }}"
       class="flex flex-col items-center gap-1.5 {{ $currentRoute === 'explore' ? 'text-jasmine' : 'text-pearl-aqua/80 hover:text-pearl-aqua' }} group transition">

        <div class="w-11 h-11 rounded-2xl {{ $currentRoute === 'explore' ? 'bg-jasmine/20' : 'bg-transparent' }} flex items-center justify-center transition-transform group-hover:scale-110">
            <i class="fa-solid fa-compass text-xl"></i>
        </div>

        <span class="text-xs {{ $currentRoute === 'explore' ? 'font-bold' : 'font-semibold' }} tracking-wider">
            Explore & Search
        </span>
    </a>


    <!-- Account -->
    <a href="{{ route('profile') }}"
       class="flex flex-col items-center gap-1.5 {{ $currentRoute === 'profile' ? 'text-jasmine' : 'text-pearl-aqua/80 hover:text-pearl-aqua' }} group transition">

        <div class="w-11 h-11 rounded-2xl {{ $currentRoute === 'profile' ? 'bg-jasmine/20' : 'bg-transparent' }} flex items-center justify-center transition-transform group-hover:scale-110">
            <i class="fa-solid fa-circle-user text-xl"></i>
        </div>

        <span class="text-xs {{ $currentRoute === 'profile' ? 'font-bold' : 'font-semibold' }} tracking-wider">
            Account
        </span>
    </a>

</nav>
