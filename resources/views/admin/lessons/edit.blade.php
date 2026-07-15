@extends('admin.layout')

@section('title', 'Edit Lesson')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Course</label>
                <select name="course_id">
                    <option value="">No course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id', $lesson->course_id) == $course->id)>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}">
            </div>
            <div class="mb-3">
                <label>Level</label>
                <select name="level">
                    <option value="beginner" @selected(old('level', $lesson->level) === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('level', $lesson->level) === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('level', $lesson->level) === 'advanced')>Advanced</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Difficulty</label>
                <select name="difficulty">
                    <option value="beginner" @selected(old('difficulty', $lesson->difficulty) === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('difficulty', $lesson->difficulty) === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('difficulty', $lesson->difficulty) === 'advanced')>Advanced</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Video URL</label>
                <input type="text" name="video_url" value="{{ old('video_url', $lesson->video_url) }}">
            </div>
            <div class="mb-3">
                <label>Content</label>
                <textarea name="content" rows="8">{{ old('content', $lesson->content) }}</textarea>
            </div>
            <div class="mb-3">
                <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $lesson->is_published))> Published</label>
            </div>
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
@endsection
