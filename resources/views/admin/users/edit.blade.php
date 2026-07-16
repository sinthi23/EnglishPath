@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    <!-- Header with Back action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Edit User Profile</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Update account information, authorization levels, and passwords.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.users.index') }}">
            Back to User List
        </a>
    </div>

    <!-- Form Panel -->
    <div class="card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name">Name / Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                </div>
                <div>
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <div>
                <label for="role">User Role</label>
                <select id="role" name="role">
                    <option value="student" @selected(old('role', $user->role) === 'student')>Student (Standard Access)</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrator (Full Access)</option>
                </select>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5 space-y-4">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Change Password (Leave blank to keep current)</p>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div>
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Update Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
