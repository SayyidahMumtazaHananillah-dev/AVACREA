@php
    $currentRoute = Route::currentRouteName();
@endphp

<!-- Bottom Navbar -->
<nav class="fixed bottom-0 left-0 w-full h-16 bg-space-indigo px-4 md:px-8 flex items-center justify-around z-50 shadow-2xl border-t border-white/10">

    <!-- Home -->
    <a href="{{ route('dashboard') }}"
       class="flex flex-col items-center gap-1.5 transition {{ $currentRoute === 'dashboard' ? 'text-jasmine' : 'text-pearl-aqua/80 hover:text-pearl-aqua' }}">
        <div class="w-11 h-11 relative top-2 rounded-2xl flex items-center justify-center transition-transform hover:scale-110 {{ $currentRoute === 'dashboard' ? 'bg-jasmine/20' : 'bg-transparent' }}">
            <i class="fa-solid fa-house text-xl"></i>
        </div>
        <span class="text-xs {{ $currentRoute === 'dashboard' ? 'font-bold' : 'font-semibold' }} tracking-wider">Home</span>
    </a>

    <!-- Explore & Search -->
    <a href="{{ route('explore') }}"
       class="flex flex-col items-center gap-1.5 transition {{ $currentRoute === 'explore' ? 'text-jasmine' : 'text-pearl-aqua/80 hover:text-pearl-aqua' }}">
        <div class="w-11 h-11 relative top-2 rounded-2xl flex items-center justify-center transition-transform hover:scale-110 {{ $currentRoute === 'explore' ? 'bg-jasmine/20' : 'bg-transparent' }}">
            <i class="fa-solid fa-compass text-xl"></i>
        </div>
        <span class="text-xs {{ $currentRoute === 'explore' ? 'font-bold' : 'font-semibold' }} tracking-wider">Explore & Search</span>
    </a>

    <!-- Account -->
    <a href="{{ route('profile') }}"
       class="flex flex-col items-center gap-1.5 transition {{ $currentRoute === 'profile' ? 'text-jasmine' : 'text-pearl-aqua/80 hover:text-pearl-aqua' }}">
        <div class="w-11 h-11 relative top-2 rounded-2xl flex items-center justify-center transition-transform hover:scale-110 {{ $currentRoute === 'profile' ? 'bg-jasmine/20' : 'bg-transparent' }}">
            <i class="fa-solid fa-circle-user text-xl"></i>
        </div>
        <span class="text-xs {{ $currentRoute === 'profile' ? 'font-bold' : 'font-semibold' }} tracking-wider">Account</span>
    </a>

</nav>