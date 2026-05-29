<nav x-data="{ open: false }" class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 px-6 py-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                <x-application-logo class="block h-9 w-auto" />
            </a>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium border-b-2 {{ request()->routeIs('home') ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-700 hover:text-gray-900 hover:bg-gray-100 hover:border-gray-300' }} rounded-md transition">
                            Beranda
                        </a>
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-700 hover:text-gray-900 hover:bg-gray-100 hover:border-gray-300' }} rounded-md transition">
                            Dashboard Admin
                        </a>
                        <a href="{{ route('admin.articles.index') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium border-b-2 {{ request()->routeIs('admin.articles.index') ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-700 hover:text-gray-900 hover:bg-gray-100 hover:border-gray-300' }} rounded-md transition">
                            Kelola Artikel
                        </a>
                        <a href="{{ route('admin.articles.archive') }}"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium border-b-2 {{ request()->routeIs('admin.articles.archive') ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-700 hover:text-gray-900 hover:bg-gray-100 hover:border-gray-300' }} rounded-md transition">
                            Arsip Mading
                        </a>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4">
            @auth
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ request()->routeIs('bookmarks.index') ? route('home') : route('bookmarks.index') }}"
                       class="font-bold border-2 border-indigo-600 text-indigo-600 px-5 py-2 rounded-full bg-indigo-50 hover:bg-indigo-100 transition flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        {{ request()->routeIs('bookmarks.index') ? 'Dashboard' : 'Bookmark' }}
                    </a>
                @endif

                <x-dropdown align="right" width="64" contentClasses="bg-white">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5 bg-indigo-600 text-white pl-2 pr-4 py-2 rounded-full font-bold hover:bg-indigo-700 transition focus:outline-none focus:ring-4 focus:ring-indigo-300"
                                x-data="{ avatarUrl: '{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '' }}' }"
                                @avatar-updated.window="avatarUrl = $event.detail">
                            <template x-if="avatarUrl">
                                <img :src="avatarUrl" class="w-8 h-8 rounded-full object-cover border border-white/20 shadow-sm">
                            </template>
                            <template x-if="!avatarUrl">
                                <span class="w-8 h-8 rounded-full bg-purple-400 text-white flex items-center justify-center text-sm font-bold uppercase">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </template>
                            <span class="max-w-[120px] truncate text-sm">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 bg-indigo-50 border-b border-gray-100">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-0.5">Masuk sebagai</p>
                            <p class="font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition group">
                                <span class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-indigo-100 flex items-center justify-center transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                Profile
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 transition group">
                                    <span class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-red-100 flex items-center justify-center transition flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" class="font-bold border-2 border-indigo-600 text-indigo-600 px-5 py-2 rounded-full hover:bg-indigo-50 transition">
                    Masuk
                </a>
            @endif
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        Beranda
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Dashboard Admin
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.index')">
                        Kelola Artikel
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.articles.archive')" :active="request()->routeIs('admin.articles.archive')">
                        Arsip Mading
                    </x-responsive-nav-link>
                @else
                    @unless(request()->routeIs('bookmarks.index'))
                        <x-responsive-nav-link :href="route('bookmarks.index')" :active="request()->routeIs('bookmarks.index')">
                            Bookmark
                        </x-responsive-nav-link>
                    @endunless
                @endif
            @endauth
        </div>

        @auth
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
        @endauth
    </div>
</nav>