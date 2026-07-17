@extends('admin.layout')

@section('title', 'Create User')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    <!-- Header with Back action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Add New User</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Create a new student or administrative account.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.users.index') }}">
            Back to User List
        </a>
    </div>

    <!-- Form Panel -->
    <div class="card">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf
            
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name">Name / Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter username" required autofocus>
                </div>
                <div>
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="user@example.com" required>
                </div>
            </div>

            <div>
                <label for="role">User Role</label>
                <select id="role" name="role">
                    <option value="student">Student (Standard Access)</option>
                    <option value="admin">Administrator (Full Access)</option>
                </select>
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

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
