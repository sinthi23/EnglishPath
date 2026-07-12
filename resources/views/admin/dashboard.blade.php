@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:16px; flex-wrap:wrap;">
            <div>
                <h1>Admin Dashboard</h1>
                <p>Use the menu to manage courses, lessons, vocabulary, quizzes, reading passages, and users.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('admin.users.create-admin') }}">Add Admin</a>
        </div>
    </div>
@endsection
