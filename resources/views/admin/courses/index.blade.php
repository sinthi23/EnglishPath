@extends('admin.layout')

@section('title', 'Courses')

@section('content')
    <div class="card">
        <a class="btn btn-primary" href="{{ route('admin.courses.create') }}">Add Course</a>
    </div>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Level</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($courses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->level }}</td>
                <td>{{ $course->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a class="btn btn-secondary" href="{{ route('admin.courses.edit', $course) }}">Edit</a>
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card">{{ $courses->links() }}</div>
@endsection
