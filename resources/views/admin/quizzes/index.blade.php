@extends('admin.layout')

@section('title', 'Quizzes')

@section('content')
    <div class="card">
        <a class="btn btn-primary" href="{{ route('admin.quizzes.create') }}">Add Quiz</a>
    </div>
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Difficulty</th>
            <th>Score</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->difficulty }}</td>
                <td>{{ $quiz->passing_score }}</td>
                <td>
                    <a class="btn btn-secondary" href="{{ route('admin.quizzes.edit', $quiz) }}">Edit</a>
                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="card">{{ $quizzes->links() }}</div>
@endsection
