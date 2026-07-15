@extends('admin.layout')

@section('title', 'Edit Course')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}">
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" rows="4">{{ old('description', $course->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label>Level</label>
                <select name="level">
                    <option value="beginner" @selected(old('level', $course->level) === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('level', $course->level) === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('level', $course->level) === 'advanced')>Advanced</option>
                </select>
            </div>
            <div class="mb-3">
                <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $course->is_published))> Published</label>
            </div>
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
@endsection
