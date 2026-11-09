<!-- Top Navbar -->
<header class="h-16 px-8 flex items-center justify-between border-b border-[#36210E]/20 bg-[#36210E]/95 backdrop-blur-md z-20 shrink-0">

    <!-- Logo AVACREA -->
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-princeton-orange flex items-center justify-center shadow-md shadow-princeton-orange/30">
            <i class="fa-solid fa-wand-magic-sparkles text-[#F0ECE1] text-lg"></i>
        </div>

        <div>
            <h1 class="text-xl font-black tracking-wider text-[#F0ECE1]">AVACREA</h1>
            <p class="text-[10px] text-princeton-orange font-bold tracking-widest uppercase">
                OC Studio Online
            </p>
        </div>
    </a>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf

        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 font-bold text-xs rounded-xl shadow-sm hover:scale-105 active:scale-95 transition-all">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </button>
    </form>

</header>

