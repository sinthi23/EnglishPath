@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
@php
    $coursesCount = \App\Models\Course::count();
    $lessonsCount = \App\Models\Lesson::count();
    $quizzesCount = \App\Models\Quiz::count();
    $readingsCount = \App\Models\ReadingPassage::count();
    $usersCount = \App\Models\User::count();
    $studentsCount = \App\Models\User::where('role', 'student')->count();
    $adminsCount = \App\Models\User::where('role', 'admin')->count();
@endphp

<div class="space-y-8">
    <!-- Welcome card banner -->
    <div class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-sm dark:bg-slate-900 dark:border-slate-800/60">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-indigo-600 dark:text-indigo-400">Admin Dashboard</p>
                <h1 class="mt-2 text-2xl font-extrabold text-slate-950 dark:text-white tracking-tight">System Statistics Overview</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">Manage courses, lessons, quizzes, reading materials, and user authorization levels.</p>
            </div>
            <a class="btn btn-primary px-5 py-3 text-xs" href="{{ route('admin.users.create-admin') }}">
                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Add New Admin
            </a>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Courses Widget -->
        <div class="card flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.04)] dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.12)] hover:border-indigo-200/80 dark:hover:border-indigo-500/30">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Courses</p>
                <p class="mt-3 text-4xl font-extrabold text-slate-900 dark:text-white">{{ $coursesCount }}</p>
            </div>
            <div class="mt-4 pt-3.5 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">Manage course catalogs</span>
                <a href="{{ route('admin.courses.index') }}" class="text-xs font-bold text-indigo-600 hover:underline dark:text-indigo-400">View courses →</a>
            </div>
        </div>

        <!-- Lessons Widget -->
        <div class="card flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.04)] dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.12)] hover:border-indigo-200/80 dark:hover:border-indigo-500/30">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Lessons Catalog</p>
                <p class="mt-3 text-4xl font-extrabold text-slate-900 dark:text-white">{{ $lessonsCount }}</p>
            </div>
            <div class="mt-4 pt-3.5 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">Active study sheets</span>
                <a href="{{ route('admin.lessons.index') }}" class="text-xs font-bold text-indigo-600 hover:underline dark:text-indigo-400">View lessons →</a>
            </div>
        </div>


        <!-- Quizzes Widget -->
        <div class="card flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.04)] dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.12)] hover:border-indigo-200/80 dark:hover:border-indigo-500/30">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Interactive Quizzes</p>
                <p class="mt-3 text-4xl font-extrabold text-slate-900 dark:text-white">{{ $quizzesCount }}</p>
            </div>
            <div class="mt-4 pt-3.5 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">Evaluation questionnaires</span>
                <a href="{{ route('admin.quizzes.index') }}" class="text-xs font-bold text-indigo-600 hover:underline dark:text-indigo-400">View quizzes →</a>
            </div>
        </div>

        <!-- Reading Passages Widget -->
        <div class="card flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.04)] dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.12)] hover:border-indigo-200/80 dark:hover:border-indigo-500/30">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Reading Passages</p>
                <p class="mt-3 text-4xl font-extrabold text-slate-900 dark:text-white">{{ $readingsCount }}</p>
            </div>
            <div class="mt-4 pt-3.5 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">Comprehension articles</span>
                <a href="{{ route('admin.readings.index') }}" class="text-xs font-bold text-indigo-600 hover:underline dark:text-indigo-400">View reading →</a>
            </div>
        </div>

        <!-- User Accounts Widget -->
        <div class="card flex flex-col justify-between transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.04)] dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.12)] hover:border-indigo-200/80 dark:hover:border-indigo-500/30">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">User Accounts</p>
                <p class="mt-3 text-4.5xl font-extrabold text-slate-900 dark:text-white">
                    {{ $usersCount }}
                    <span class="text-xs font-medium text-slate-400 block mt-1">
                        ({{ $studentsCount }} Students, {{ $adminsCount }} Admins)
                    </span>
                </p>
            </div>
            <div class="mt-4 pt-3.5 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-400">Registered users log</span>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-indigo-600 hover:underline dark:text-indigo-400">View users →</a>
            </div>
        </div>
    </div>

    <!-- Quick action links -->
    <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dark:bg-slate-900 dark:border-slate-800/60">
        <h3 class="text-base font-bold text-slate-955 dark:text-white mb-4">Quick Operations</h3>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('admin.courses.create') }}" class="btn btn-secondary text-xs px-4 py-2 hover:bg-slate-50">Create Course</a>
            <a href="{{ route('admin.lessons.create') }}" class="btn btn-secondary text-xs px-4 py-2 hover:bg-slate-50">Create Lesson</a>
            <a href="{{ route('admin.quizzes.create') }}" class="btn btn-secondary text-xs px-4 py-2 hover:bg-slate-50">Create Quiz</a>
            <a href="{{ route('admin.readings.create') }}" class="btn btn-secondary text-xs px-4 py-2 hover:bg-slate-50">Add Reading Passage</a>
        </div>
    </div>
</div>
@endsection
