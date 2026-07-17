<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - EnglishPath</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Theme Initialization script to prevent flash -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative isolate min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.12),_transparent_30%),linear-gradient(135deg,_#f8fbff_0%,_#eef2ff_100%)] dark:bg-gradient-to-br dark:from-slate-950 dark:via-slate-950 dark:to-indigo-950/40 font-sans text-slate-800 dark:text-slate-200 antialiased pb-12 overflow-x-hidden">
    <!-- Premium background pattern overlays -->
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-40 h-[36rem] w-[36rem] rounded-full bg-sky-400/8 blur-3xl animate-pulse" style="animation-duration: 9s;"></div>
        <div class="absolute bottom-10 right-20 h-[40rem] w-[40rem] rounded-full bg-indigo-400/8 blur-3xl animate-pulse" style="animation-duration: 14s;"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1600&q=80')] bg-cover bg-center opacity-[0.03] mix-blend-overlay"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="rounded-[2.25rem] border border-slate-900/60 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 px-6 py-6 text-white shadow-[0_30px_70px_rgba(15,23,42,0.22)]">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-sky-400 animate-pulse"></span>
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-sky-400">EnglishPath Admin Hub</p>
                    </div>
                    <h1 class="mt-2 text-2xl font-extrabold tracking-tight">Platform Management Panel</h1>
                    <p class="mt-1.5 text-xs text-slate-400 flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Logged in as: <span class="font-semibold text-sky-300">{{ auth()->user()->email }}</span>
                    </p>
                </div>
                <nav class="flex flex-wrap gap-1.5 text-xs font-semibold">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-full px-4 py-2.5 transition {{ request()->routeIs('admin.dashboard') ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                    <a href="{{ route('admin.courses.index') }}" class="rounded-full px-4 py-2.5 transition {{ request()->routeIs('admin.courses.*') ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">Courses</a>
                    <a href="{{ route('admin.lessons.index') }}" class="rounded-full px-4 py-2.5 transition {{ request()->routeIs('admin.lessons.*') ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">Lessons</a>
                    <a href="{{ route('admin.vocabularies.index') }}" class="rounded-full px-4 py-2.5 transition {{ request()->routeIs('admin.vocabularies.*') ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">Vocabulary</a>
                    <a href="{{ route('admin.quizzes.index') }}" class="rounded-full px-4 py-2.5 transition {{ request()->routeIs('admin.quizzes.*') ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">Quizzes</a>
                    <a href="{{ route('admin.readings.index') }}" class="rounded-full px-4 py-2.5 transition {{ request()->routeIs('admin.readings.*') ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">Reading</a>
                    <a href="{{ route('admin.users.index') }}" class="rounded-full px-4 py-2.5 transition {{ request()->routeIs('admin.users.*') ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">Users</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                        @csrf
                        <button type="submit" class="rounded-full bg-white/5 px-4 py-2.5 text-slate-300 font-semibold transition hover:bg-rose-500/20 hover:text-rose-200 hover:border-rose-500/20">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="mt-6 rounded-[2.25rem] border border-slate-200/50 bg-white/75 p-5 shadow-[0_25px_60px_rgba(15,23,42,0.05)] backdrop-blur-md dark:border-slate-800/60 dark:bg-slate-900/75 sm:p-8 lg:p-10">
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3.5 rounded-2xl border border-emerald-500/10 bg-emerald-500/5 px-4 py-3 text-sm text-emerald-800">
                    <svg class="h-5 w-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-500/10 bg-rose-500/5 px-5 py-4 text-sm text-rose-800">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="font-bold">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc space-y-1 pl-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
