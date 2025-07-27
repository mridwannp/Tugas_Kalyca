<!-- Sidebar -->
<aside class="w-64 h-screen bg-gradient-to-b from-blue-700 to-blue-900 text-white fixed top-0 left-0 shadow-lg">
    <div class="px-6 py-5 text-2xl font-semibold border-b border-blue-600">
        <a href="{{ route('dashboard') }}" class="block hover:text-yellow-300 transition-all">TOKO ANAK</a>
    </div>

    <nav class="mt-6">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center px-6 py-3 hover:bg-blue-600 hover:pl-7 transition-all duration-200 {{ request()->is('dashboard') ? 'bg-blue-800' : '' }}">
                    <span class="material-icons mr-3">dashboard</span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('masukan.index') }}"
                   class="flex items-center px-6 py-3 hover:bg-blue-600 hover:pl-7 transition-all duration-200 {{ request()->is('masukan*') ? 'bg-blue-800' : '' }}">
                    <span class="material-icons mr-3">trending_up</span>
                    Masukan
                </a>
            </li>
            <li>
                <a href="{{ route('pengeluaran.index') }}"
                   class="flex items-center px-6 py-3 hover:bg-blue-600 hover:pl-7 transition-all duration-200 {{ request()->is('pengeluaran*') ? 'bg-blue-800' : '' }}">
                    <span class="material-icons mr-3">trending_down</span>
                    Keluaran
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('laporan.index') }}"
                   class="flex items-center px-6 py-3 hover:bg-blue-600 hover:pl-7 transition-all duration-200 {{ request()->is('laporan*') ? 'bg-blue-800' : '' }}">
                    <span class="material-icons mr-3">assessment</span>
                    Laporan
                </a>
            </li> --}}
        </ul>
    </nav>

    <div class="absolute bottom-0 w-full border-t border-blue-700">
        <div class="px-6 py-4">
            <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
            <div class="text-xs text-blue-300">{{ Auth::user()->email }}</div>

            <div class="mt-2">
                <a href="{{ route('profile.edit') }}" class="text-sm hover:underline">Edit Profile</a> |
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm hover:underline text-red-300">Logout</button>
                </form>
            </div>
        </div>
    </div>
</aside>
