@extends('admin.layout')

@section('title', 'Create Lesson')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.lessons.store') }}">
            @csrf
            <div class="mb-3">
                <label>Course</label>
                <select name="course_id">
                    <option value="">No course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}">
            </div>
            <div class="mb-3">
                <label>Level</label>
                <select name="level">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Difficulty</label>
                <select name="difficulty">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Video URL</label>
                <input type="text" name="video_url" value="{{ old('video_url') }}">
            </div>
            <div class="mb-3">
                <label>Content</label>
                <textarea name="content" rows="8">{{ old('content') }}</textarea>
            </div>
            <div class="mb-3">
                <label><input type="checkbox" name="is_published" value="1" checked> Published</label>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
@endsection
