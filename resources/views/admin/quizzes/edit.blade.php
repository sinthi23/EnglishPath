@extends('admin.layout')

@section('title', 'Edit Quiz')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Lesson</label>
                <select name="lesson_id">
                    <option value="">No lesson</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}" @selected(old('lesson_id', $quiz->lesson_id) == $lesson->id)>{{ $lesson->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Reading Passage</label>
                <select name="reading_passage_id">
                    <option value="">No reading passage</option>
                    @foreach ($readings as $reading)
                        <option value="{{ $reading->id }}" @selected(old('reading_passage_id', $quiz->reading_passage_id) == $reading->id)>{{ $reading->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3"><label>Title</label><input type="text" name="title" value="{{ old('title', $quiz->title) }}"></div>
            <div class="mb-3">
                <label>Difficulty</label>
                <select name="difficulty">
                    <option value="beginner" @selected(old('difficulty', $quiz->difficulty) === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('difficulty', $quiz->difficulty) === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('difficulty', $quiz->difficulty) === 'advanced')>Advanced</option>
                </select>
            </div>
            <div class="mb-3"><label>Time Limit (minutes)</label><input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}"></div>
            <div class="mb-3"><label>Passing Score</label><input type="number" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}"></div>
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
@endsection
