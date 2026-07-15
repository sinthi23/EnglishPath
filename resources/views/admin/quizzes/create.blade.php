@extends('admin.layout')

@section('title', 'Create Quiz')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.quizzes.store') }}">
            @csrf
            <div class="mb-3">
                <label>Lesson</label>
                <select name="lesson_id">
                    <option value="">No lesson</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Reading Passage</label>
                <select name="reading_passage_id">
                    <option value="">No reading passage</option>
                    @foreach ($readings as $reading)
                        <option value="{{ $reading->id }}">{{ $reading->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3"><label>Title</label><input type="text" name="title" value="{{ old('title') }}"></div>
            <div class="mb-3">
                <label>Difficulty</label>
                <select name="difficulty">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
            <div class="mb-3"><label>Time Limit (minutes)</label><input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes') }}"></div>
            <div class="mb-3"><label>Passing Score</label><input type="number" name="passing_score" value="50"></div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
@endsection
