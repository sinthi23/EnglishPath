@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Admin dashboard</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">Welcome back to your management hub</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Use the menu above to manage courses, lessons, vocabulary, quizzes, reading passages, and users with a polished and organized workflow.</p>
            </div>
            <a class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800" href="{{ route('admin.users.create-admin') }}">Add Admin</a>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm font-medium text-slate-500">Content control</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">Courses, lessons, readings</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm font-medium text-slate-500">Learning tools</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">Vocabulary and quizzes</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="text-sm font-medium text-slate-500">User access</p>
                <p class="mt-2 text-xl font-semibold text-slate-900">Admin and student management</p>
            </div>
        </div>
    </div>
@endsection
