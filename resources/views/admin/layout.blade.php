<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - EnglishPath</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f7f7fb; color: #1f2937; }
        header { background: #111827; color: white; padding: 16px 24px; }
        nav a { color: white; margin-right: 12px; text-decoration: none; }
        main { padding: 24px; }
        .card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 8px 24px rgba(0,0,0,.06); }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #e5e7eb; padding: 10px; text-align: left; }
        th { background: #f3f4f6; }
        .btn { display: inline-block; padding: 8px 12px; border-radius: 8px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-danger { background: #dc2626; color: white; }
        .btn-secondary { background: #6b7280; color: white; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .text-success { color: #15803d; }
        .text-danger { color: #b91c1c; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; }
        label { display: block; font-weight: bold; margin-bottom: 6px; }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.courses.index') }}">Courses</a>
        <a href="{{ route('admin.lessons.index') }}">Lessons</a>
        <a href="{{ route('admin.vocabularies.index') }}">Vocabulary</a>
        <a href="{{ route('admin.quizzes.index') }}">Quizzes</a>
        <a href="{{ route('admin.readings.index') }}">Reading</a>
        <a href="{{ route('admin.users.index') }}">Users</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline; margin-left: 12px;">
            @csrf
            <button type="submit" class="btn btn-secondary" style="padding: 0; background: transparent; color: white; font: inherit;">Logout</button>
        </form>
    </nav>
</header>
<main>
    @if (session('success'))
        <div class="card text-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="card text-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
