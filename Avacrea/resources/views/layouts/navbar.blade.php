<!-- Top Navbar -->
<header class="fixed top-0 left-0 w-full h-16 px-8 flex items-center justify-between border-b border-[#36210E]/20 bg-[#36210E]/95 backdrop-blur-md z-50">
    <!-- Logo AVACREA -->
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-princeton-orange flex items-center justify-center shadow-md shadow-princeton-orange/30">
            <i class="fa-solid fa-wand-magic-sparkles text-[#F0ECE1] text-lg"></i>
        </div>
        <div>
            <h1 class="text-xl font-black tracking-wider text-[#F0ECE1]">AVACREA</h1>
            <p class="text-[10px] text-princeton-orange font-bold tracking-widest uppercase">OC Studio Online</p>
        </div>
    </a>

    @auth
        <div class="flex items-center gap-3">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-2 px-4 py-2 bg-princeton-orange/20 hover:bg-princeton-orange/30 border border-princeton-orange/40 text-orange-200 font-bold text-xs rounded-xl transition-all">
                    <i class="fa-solid fa-gauge-high"></i>
                    <span>Admin Dashboard</span>
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/40 text-rose-200 font-bold text-xs rounded-xl shadow-sm hover:scale-105 active:scale-95 transition-all">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    @else
        <a href="{{ route('login') }}" class="flex items-center gap-2 px-5 py-2.5 bg-princeton-orange hover:bg-orange-600 text-white font-extrabold text-xs rounded-xl shadow-md shadow-princeton-orange/30 hover:scale-105 active:scale-95 transition-all">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>Login</span>
        </a>
    @endauth

</header>