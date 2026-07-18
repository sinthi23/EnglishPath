<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnglishPath') }}</title>

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

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.25),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(129,140,248,0.25),_transparent_30%),linear-gradient(135deg,_#f8fbff_0%,_#eef4ff_45%,_#fef7ed_100%)] font-sans text-slate-900 antialiased">
        <div class="relative isolate min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div class="absolute -left-8 top-10 h-56 w-56 rounded-full bg-sky-400/20 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 h-72 w-72 rounded-full bg-fuchsia-400/20 blur-3xl"></div>
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=1600&q=80')] bg-cover bg-center opacity-20"></div>
            </div>

            <div class="relative flex min-h-screen items-center justify-center px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
                <div class="mx-auto flex w-full max-w-7xl flex-col overflow-hidden rounded-[2.25rem] border border-white/80 dark:border-slate-800/85 bg-white/60 dark:bg-slate-900/65 shadow-[0_35px_120px_rgba(15,23,42,0.18)] backdrop-blur-2xl lg:flex-row">
                    <div class="flex-1 bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 p-8 text-white sm:p-10 lg:p-12 xl:p-16 flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center rounded-full border border-sky-400/30 bg-sky-500/10 px-3.5 py-1 text-xs font-semibold tracking-wider uppercase text-sky-200">
                                EnglishPath • Premium Learning Hub
                            </div>
                            <h1 class="mt-8 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl bg-gradient-to-r from-white via-slate-100 to-sky-200 bg-clip-text text-transparent">
                                Practice English like a modern learner.
                            </h1>
                            <p class="mt-5 max-w-2xl text-sm leading-8 text-slate-300 sm:text-base">
                                Explore interactive lessons, expand vocabulary, and stay motivated with a beautifully designed experience that feels polished, responsive, and professional.
                            </p>
                        </div>

                        <div class="mt-12 grid gap-4 text-sm text-slate-200 sm:grid-cols-2">
                            <div class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition duration-300 hover:bg-white/10 hover:border-white/20">
                                <div class="text-2xl transition duration-300 group-hover:scale-110 group-hover:translate-x-0.5 inline-block text-sky-400">✦</div>
                                <p class="mt-3 font-semibold text-white">Structured Lessons</p>
                                <p class="mt-1 text-xs text-slate-400">Curated materials matching your capability level.</p>
                            </div>
                            <div class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition duration-300 hover:bg-white/10 hover:border-white/20">
                                <div class="text-2xl transition duration-300 group-hover:scale-110 group-hover:translate-x-0.5 inline-block text-amber-400">✓</div>
                                <p class="mt-3 font-semibold text-white">Vocabulary Growth</p>
                                <p class="mt-1 text-xs text-slate-400">Search and save words to your personal deck.</p>
                            </div>
                            <div class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition duration-300 hover:bg-white/10 hover:border-white/20">
                                <div class="text-2xl transition duration-300 group-hover:scale-110 group-hover:translate-x-0.5 inline-block text-emerald-400">↗</div>
                                <p class="mt-3 font-semibold text-white">Progress Tracking</p>
                                <p class="mt-1 text-xs text-slate-400">Visualize completed lessons and quiz history.</p>
                            </div>
                            <div class="group rounded-2xl border border-white/10 bg-white/5 p-5 transition duration-300 hover:bg-white/10 hover:border-white/20">
                                <div class="text-2xl transition duration-300 group-hover:scale-110 group-hover:translate-x-0.5 inline-block text-fuchsia-400">★</div>
                                <p class="mt-3 font-semibold text-white">Professional UI</p>
                                <p class="mt-1 text-xs text-slate-400">Designed to give you the clean interface you deserve.</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full bg-white/95 dark:bg-slate-950/95 p-6 sm:p-10 lg:w-[460px] lg:p-10 xl:p-12 flex flex-col justify-center">
                        <div class="mb-8 flex items-center justify-between gap-3">
                            <a href="/" class="flex items-center gap-3">
                                <div class="relative flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 shadow-md shadow-indigo-950/20">
                                    <svg class="h-5.5 w-5.5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.08 1.477 4.5 2.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 2.253" />
                                    </svg>
                                    <span class="absolute -bottom-0.5 -right-0.5 flex h-3 w-3 items-center justify-center rounded-full bg-sky-500 ring-2 ring-white dark:ring-slate-950">
                                        <span class="h-1 w-1 rounded-full bg-white"></span>
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white tracking-tight">EnglishPath</p>
                                    <p class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Student portal</p>
                                </div>
                            </a>
                            <a href="{{ route('register') }}" class="rounded-full border border-slate-200/80 dark:border-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 transition hover:bg-slate-50 dark:hover:bg-slate-900 hover:text-slate-900 dark:hover:text-white active:scale-95">Create account</a>
                        </div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
