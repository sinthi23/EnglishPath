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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="relative isolate min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.12),_transparent_25%),linear-gradient(135deg,_#f7fbff_0%,_#f5f3ff_100%)] dark:bg-gradient-to-br dark:from-slate-950 dark:via-slate-950 dark:to-indigo-950/40 font-sans text-slate-800 dark:text-slate-200 antialiased overflow-x-hidden">
        <!-- Premium background pattern overlays -->
        <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -left-16 top-20 h-[30rem] w-[30rem] rounded-full bg-sky-400/8 blur-3xl dark:bg-sky-500/3 animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute bottom-20 right-10 h-[36rem] w-[36rem] rounded-full bg-indigo-400/8 blur-3xl dark:bg-indigo-500/3 animate-pulse" style="animation-duration: 12s;"></div>
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1600&q=80')] bg-cover bg-center opacity-[0.035] dark:opacity-[0.015] mix-blend-overlay"></div>
        </div>

        <div class="min-h-screen pb-12">
            @include('layouts.navigation')

            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3.5 rounded-2xl border border-emerald-500/10 bg-emerald-500/5 px-4 py-3 text-sm text-emerald-800 shadow-[0_4px_20px_rgba(16,185,129,0.03)] backdrop-blur-sm dark:text-emerald-400">
                        <svg class="h-5 w-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 flex items-center gap-3.5 rounded-2xl border border-rose-500/10 bg-rose-500/5 px-4 py-3 text-sm text-rose-800 shadow-[0_4px_20px_rgba(244,63,94,0.03)] backdrop-blur-sm dark:text-rose-400">
                        <svg class="h-5 w-5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @isset($header)
                    <header class="mb-6 rounded-[2rem] border border-slate-200/50 bg-white/70 p-6 shadow-[0_15px_45px_rgba(15,23,42,0.04)] backdrop-blur-md dark:border-slate-800/60 dark:bg-slate-900/75">
                        {{ $header }}
                    </header>
                @endisset

                <main class="rounded-[2.25rem] border border-slate-200/50 bg-white/75 p-5 shadow-[0_25px_60px_rgba(15,23,42,0.05)] backdrop-blur-md dark:border-slate-800/60 dark:bg-slate-900/75 sm:p-8 lg:p-10">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
