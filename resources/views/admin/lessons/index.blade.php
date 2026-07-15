@extends('admin.layout')

@section('title', 'Lessons')

@section('content')
    <div class="card">
        <a class="btn btn-primary" href="{{ route('admin.lessons.create') }}">Add Lesson</a>
    </div>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Course</th>
            <th>Level</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lessons as $lesson)
            <tr>
                <td>{{ $lesson->title }}</td>
                <td>{{ $lesson->course?->title ?? 'No course' }}</td>
                <td>{{ $lesson->level }}</td>
                <td>
                    <a class="btn btn-secondary" href="{{ route('admin.lessons.edit', $lesson) }}">Edit</a>
                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card">{{ $lessons->links() }}</div>
@endsection
