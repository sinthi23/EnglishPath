@extends('admin.layout')

@section('title', 'Create Admin')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    <!-- Header with Back action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Add New Administrator</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Create a new privileged administrative user.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.users.index') }}">
            Back to User List
        </a>
    </div>

    <!-- Form Panel -->
    <div class="card">
        <form method="POST" action="{{ route('admin.users.store-admin') }}" class="space-y-5">
            @csrf
            
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name">Name / Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter admin name" required autofocus>
                </div>
                <div>
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <div class="rounded-xl border border-sky-100 bg-sky-500/5 p-4.5 text-xs text-slate-550 dark:border-sky-950/40">
                <span class="font-bold text-sky-700 dark:text-sky-400">Security Notice:</span>
                This user account will have write privileges to add, delete, and modify courses, lessons, and student activity logs.
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Create Admin Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
