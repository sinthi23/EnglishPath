<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200/60 bg-white/75 backdrop-blur-md dark:border-slate-800/60 dark:bg-slate-950/75">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 shadow-md shadow-indigo-950/20 group-hover:scale-105 transition">
                    <svg class="h-5.5 w-5.5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.08 1.477 4.5 2.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 2.253" />
                    </svg>
                    <span class="absolute -bottom-0.5 -right-0.5 flex h-2.5 w-2.5 items-center justify-center rounded-full bg-sky-500 ring-2 ring-white dark:ring-slate-950">
                        <span class="h-1 w-1 rounded-full bg-white"></span>
                    </span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-white tracking-tight group-hover:text-indigo-600 transition">EnglishPath</p>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Learning dashboard</p>
                </div>
            </a>
        </div>

        <div class="hidden items-center gap-1.5 sm:flex">
            @if (Auth::user()?->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Dashboard</a>
            @else
                <a href="{{ route('student.dashboard') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Dashboard</a>
                <a href="{{ route('student.courses.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.courses.index') || request()->routeIs('student.courses.show') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Courses</a>
                <a href="{{ route('student.lessons.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.lessons.index') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Lessons</a>
                <a href="{{ route('student.writing.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.writing.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Writing</a>
                <a href="{{ route('student.listening.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.listening.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Listening</a>
                <a href="{{ route('student.readings.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.readings.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Reading</a>
                <a href="{{ route('student.dictionary.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.dictionary.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Dictionary</a>
                <a href="{{ route('student.bookmarks.index') }}" class="rounded-full px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('student.bookmarks.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-900 dark:hover:text-white' }}">Bookmarks</a>
            @endif
        </div>

        <div class="hidden items-center gap-3 sm:flex">
            <!-- Theme Toggle Button -->
            <button id="theme-toggle" type="button" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-900 dark:hover:text-slate-200 transition">
                <svg id="theme-toggle-dark-icon" class="hidden h-4.5 w-4.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.413 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 17.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414-14.14a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM3 10a1 1 0 011-1h1a1 1 0 110 2H4a1 1 0 01-1-1z" />
                </svg>
                <svg id="theme-toggle-light-icon" class="hidden h-4.5 w-4.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
            </button>

            <a href="{{ route('profile.edit') }}" class="rounded-full border border-slate-200/80 px-4 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-50 hover:text-slate-950 dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-900">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-full bg-slate-950 px-4 py-2 text-xs font-bold text-white transition hover:bg-slate-800 active:scale-95 shadow-md shadow-slate-950/10 dark:bg-slate-100 dark:text-slate-900">
                    Logout
                </button>
            </form>
        </div>

        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-full p-2.5 text-slate-600 transition hover:bg-slate-50 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-900">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200/60 bg-white/95 backdrop-blur-md dark:border-slate-800/60 dark:bg-slate-950/95 sm:hidden">
        <div class="space-y-1.5 px-4 py-4">
            @if (Auth::user()?->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Dashboard</a>
            @else
                <a href="{{ route('student.dashboard') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Dashboard</a>
                <a href="{{ route('student.courses.index') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Courses</a>
                <a href="{{ route('student.lessons.index') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Lessons</a>
                <a href="{{ route('student.writing.index') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Writing</a>
                <a href="{{ route('student.listening.index') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Listening</a>
                <a href="{{ route('student.readings.index') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Reading</a>
                <a href="{{ route('student.dictionary.index') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Dictionary</a>
                <a href="{{ route('student.bookmarks.index') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Bookmarks</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="block rounded-2xl px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-900">Profile</a>
            
            <!-- Mobile Toggle -->
            <div class="flex items-center justify-between rounded-2xl px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300">
                <span>Theme Mode</span>
                <button id="theme-toggle-mobile" type="button" class="rounded-full bg-slate-100 dark:bg-slate-800 px-3 py-1.5 text-xs text-slate-600 dark:text-slate-300 transition">
                    Toggle Mode
                </button>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mt-3 w-full rounded-2xl bg-slate-950 px-4 py-3 text-left text-sm font-bold text-white shadow-md shadow-slate-950/10 dark:bg-slate-100 dark:text-slate-900">Logout</button>
            </form>
        </div>
    </div>
</nav>

<script>
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons state inside button based on current theme state
    if (document.documentElement.classList.contains('dark')) {
        themeToggleDarkIcon.classList.remove('hidden');
    } else {
        themeToggleLightIcon.classList.remove('hidden');
    }

    function toggleTheme() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            themeToggleDarkIcon.classList.add('hidden');
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }
    }

    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
    document.getElementById('theme-toggle-mobile').addEventListener('click', toggleTheme);
</script>
