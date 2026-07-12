@extends('admin.layout')

@section('title', 'Create Course')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.courses.store') }}">
            @csrf
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}">
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" rows="4">{{ old('description') }}</textarea>
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
                <label><input type="checkbox" name="is_published" value="1" checked> Published</label>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
@endsection
