<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - EnglishPath</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(14,165,233,0.12),_transparent_30%),linear-gradient(135deg,_#f8fbff_0%,_#eef2ff_100%)] font-sans text-slate-800">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <header class="rounded-[1.75rem] border border-slate-200/70 bg-slate-950 px-6 py-5 text-white shadow-[0_25px_60px_rgba(15,23,42,0.16)]">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">EnglishPath Admin</p>
                    <h1 class="mt-2 text-2xl font-semibold">Manage your learning platform with clarity</h1>
                </div>
                <nav class="flex flex-wrap gap-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-full px-3 py-2 transition {{ request()->routeIs('admin.dashboard') ? 'bg-sky-500 text-white' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">Dashboard</a>
                    <a href="{{ route('admin.courses.index') }}" class="rounded-full px-3 py-2 transition {{ request()->routeIs('admin.courses.*') ? 'bg-sky-500 text-white' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">Courses</a>
                    <a href="{{ route('admin.lessons.index') }}" class="rounded-full px-3 py-2 transition {{ request()->routeIs('admin.lessons.*') ? 'bg-sky-500 text-white' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">Lessons</a>
                    <a href="{{ route('admin.vocabularies.index') }}" class="rounded-full px-3 py-2 transition {{ request()->routeIs('admin.vocabularies.*') ? 'bg-sky-500 text-white' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">Vocabulary</a>
                    <a href="{{ route('admin.quizzes.index') }}" class="rounded-full px-3 py-2 transition {{ request()->routeIs('admin.quizzes.*') ? 'bg-sky-500 text-white' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">Quizzes</a>
                    <a href="{{ route('admin.readings.index') }}" class="rounded-full px-3 py-2 transition {{ request()->routeIs('admin.readings.*') ? 'bg-sky-500 text-white' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">Reading</a>
                    <a href="{{ route('admin.users.index') }}" class="rounded-full px-3 py-2 transition {{ request()->routeIs('admin.users.*') ? 'bg-sky-500 text-white' : 'bg-white/10 text-slate-200 hover:bg-white/20' }}">Users</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                        @csrf
                        <button type="submit" class="rounded-full bg-white/10 px-3 py-2 text-slate-200 transition hover:bg-white/20">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="mt-6 rounded-[2rem] border border-slate-200/70 bg-white/85 p-4 shadow-[0_20px_45px_rgba(15,23,42,0.08)] backdrop-blur sm:p-6 lg:p-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-disc space-y-1 pl-5">
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
