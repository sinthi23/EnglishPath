@extends('admin.layout')

@section('title', 'Reading Passages')

@section('content')
    <div class="card">
        <a class="btn btn-primary" href="{{ route('admin.readings.create') }}">Add Reading</a>
    </div>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Difficulty</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($readingPassages as $readingPassage)
            <tr>
                <td>{{ $readingPassage->title }}</td>
                <td>{{ $readingPassage->difficulty }}</td>
                <td>{{ $readingPassage->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a class="btn btn-secondary" href="{{ route('admin.readings.edit', $readingPassage) }}">Edit</a>
                    <form action="{{ route('admin.readings.destroy', $readingPassage) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card">{{ $readingPassages->links() }}</div>
@endsection
