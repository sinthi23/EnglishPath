<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>EnglishPath - Premium Online English Learning Platform</title>

        <!-- Fonts -->
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

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="relative isolate min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.12),_transparent_30%),linear-gradient(135deg,_#f7fbff_0%,_#f5f3ff_100%)] dark:bg-gradient-to-br dark:from-slate-950 dark:via-slate-950 dark:to-indigo-950/40 font-sans text-slate-800 dark:text-slate-200 antialiased overflow-x-hidden">
        
        <!-- Premium background pattern overlays -->
        <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -left-16 top-20 h-[32rem] w-[32rem] rounded-full bg-sky-400/8 blur-3xl dark:bg-sky-500/3 animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute bottom-20 right-10 h-[38rem] w-[38rem] rounded-full bg-indigo-400/8 blur-3xl dark:bg-indigo-500/3 animate-pulse" style="animation-duration: 12s;"></div>
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1600&q=80')] bg-cover bg-center opacity-[0.035] dark:opacity-[0.015] mix-blend-overlay"></div>
        </div>

        <!-- Sticky glass header -->
        <header class="sticky top-0 z-50 w-full border-b border-slate-200/40 bg-white/70 backdrop-blur-md dark:border-slate-800/40 dark:bg-slate-950/70 transition">
            <div class="mx-auto flex max-w-7xl h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
                <!-- Advanced Custom Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 shadow-lg shadow-indigo-950/20 group-hover:scale-105 transition">
                        <!-- Abstract Gradient Icon Symbol -->
                        <svg class="h-6 w-6 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.08 1.477 4.5 2.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 2.253" />
                        </svg>
                        <span class="absolute -bottom-1 -right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-sky-500 ring-2 ring-white dark:ring-slate-950">
                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                        </span>
                    </div>
                    <div>
                        <h1 class="text-base font-extrabold tracking-tight text-slate-950 dark:text-white leading-none">EnglishPath</h1>
                        <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-sky-500 dark:text-sky-400">Learning Portal</span>
                    </div>
                </a>

                <!-- Right Nav actions -->
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle Button -->
                    <button id="theme-toggle" type="button" class="rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-900 dark:hover:text-slate-200 transition">
                        <svg id="theme-toggle-dark-icon" class="hidden h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.413 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 17.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zm1.414-14.14a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM3 10a1 1 0 011-1h1a1 1 0 110 2H4a1 1 0 01-1-1z" />
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-5 py-2.5 text-xs">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-secondary px-5 py-2.5 text-xs">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary px-5 py-2.5 text-xs hidden sm:inline-flex">Create Account</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="text-center space-y-6 max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 rounded-full border border-sky-400/20 bg-sky-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-sky-600 dark:text-sky-300">
                    <span class="h-2 w-2 rounded-full bg-sky-500 animate-pulse"></span>
                    Online English Learning Platform
                </div>
                
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl text-slate-900 dark:text-white leading-[1.1] sm:leading-[1.1]">
                    Master the English Language, <span class="bg-gradient-to-r from-indigo-600 via-sky-500 to-indigo-500 bg-clip-text text-transparent dark:from-indigo-400 dark:to-sky-400">One Path at a Time</span>
                </h1>

                <p class="text-base text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed sm:text-lg">
                    Study interactive grammar lessons, practice contextual reading, expand your active vocabulary library, and take auto-graded quizzes designed to boost your skills.
                </p>

                <div class="pt-4 flex flex-wrap items-center justify-center gap-3.5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-8 py-3.5 shadow-lg shadow-indigo-600/10">
                            Enter Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary px-8 py-3.5 shadow-lg shadow-indigo-600/10">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-secondary px-8 py-3.5">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Features Grid -->
            <div class="mt-24 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Feature 1 -->
                <div class="card relative group hover:-translate-y-1 transition duration-300">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-650 dark:bg-indigo-950/40 dark:text-indigo-400 text-2xl">
                        📚
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">Structured Lessons</h3>
                    <p class="mt-2.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Access structured reading and learning modules segmented by capability level and targeted modules.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="card relative group hover:-translate-y-1 transition duration-300">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-650 dark:bg-emerald-950/40 dark:text-emerald-450 text-2xl">
                        📝
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">Grammar & Syntax</h3>
                    <p class="mt-2.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Read specialized grammar definitions with clear examples to master write-ups and speech structure.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="card relative group hover:-translate-y-1 transition duration-300">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-650 dark:bg-amber-950/40 dark:text-amber-450 text-2xl">
                        🧠
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">Vocabulary Deck</h3>
                    <p class="mt-2.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Lookup words in real-time, view synonyms, antonyms, and save target words to your personal study card deck.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="card relative group hover:-translate-y-1 transition duration-300">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-650 dark:bg-rose-950/40 dark:text-rose-450 text-2xl">
                        ↗
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900 dark:text-white">Instant Quizzes</h3>
                    <p class="mt-2.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Take auto-graded checkpoints at the end of each module to test recall and track your daily streak progression.
                    </p>
                </div>
            </div>
        </main>



        <!-- Toggle Theme script logic -->
        <script>
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (document.documentElement.classList.contains('dark')) {
                themeToggleDarkIcon.classList.remove('hidden');
            } else {
                themeToggleLightIcon.classList.remove('hidden');
            }

            document.getElementById('theme-toggle').addEventListener('click', function() {
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
            });
        </script>
    </body>
</html>
