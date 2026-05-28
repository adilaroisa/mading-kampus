<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto" />
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-4">
                    @if(auth()->check())
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md transition">
                                Beranda
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md transition">
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md transition">
                                Kelola Artikel
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                @if(auth()->check())
                    @if(auth()->user()->role !== 'admin')
                        <a href="{{ route('bookmarks.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-indigo-500 text-indigo-600 rounded-full bg-white shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5v14l7-7 7 7V5H5z" />
                            </svg>
                            Bookmark
                        </a>
                    @endif
                @endif

                @if(auth()->check())
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-4 py-2 border border-transparent text-sm leading-4 font-bold rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white hover:shadow-lg transition ease-in-out duration-150">
                            <div class="w-6 h-6 rounded-full bg-white bg-opacity-30 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="max-w-[120px] truncate">
                                {{ Auth::user()->name }}
                            </div>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="text-xs text-gray-500 font-semibold tracking-wider">MASUK SEBAGAI</div>
                            <div class="mt-2">
                                <div class="font-bold text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="border-b border-gray-100">
                            Profil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-red-600 font-bold hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                Keluar
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 border border-indigo-500 text-indigo-600 rounded-full hover:bg-indigo-50 transition font-bold">
                        Masuk
                    </a>
                @endif
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Beranda
            </x-responsive-nav-link>
            
            @if(auth()->check())
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Dashboard Admin
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.index')">
                        Kelola Artikel
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('bookmarks.index')" :active="request()->routeIs('bookmarks.index')">
                        Daftar Bookmark
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        @if(auth()->check())
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil Akun
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-red-600 font-bold hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 space-y-2">
                <a href="{{ route('login') }}" class="block px-4 py-2 text-center rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-center rounded-lg border-2 border-indigo-600 text-indigo-600 font-bold hover:bg-indigo-50 transition">
                    Daftar
                </a>
            </div>
        </div>
        @endif
    </div>
</nav>