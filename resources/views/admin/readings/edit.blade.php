@extends('admin.layout')

@section('title', 'Edit Reading')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.readings.update', $readingPassage) }}">
            @csrf
            @method('PUT')
            <div class="mb-3"><label>Title</label><input type="text" name="title" value="{{ old('title', $readingPassage->title) }}"></div>
            <div class="mb-3">
                <label>Difficulty</label>
                <select name="difficulty">
                    <option value="beginner" @selected(old('difficulty', $readingPassage->difficulty) === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('difficulty', $readingPassage->difficulty) === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('difficulty', $readingPassage->difficulty) === 'advanced')>Advanced</option>
                </select>
            </div>
            <div class="mb-3"><label>Passage</label><textarea name="passage" rows="10">{{ old('passage', $readingPassage->passage) }}</textarea></div>
            <div class="mb-3"><label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $readingPassage->is_published))> Published</label></div>
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
@endsection
