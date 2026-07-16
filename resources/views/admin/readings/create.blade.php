@extends('admin.layout')

@section('title', 'Create Reading')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.readings.store') }}">
            @csrf
            <div class="mb-3"><label>Title</label><input type="text" name="title" value="{{ old('title') }}"></div>
            <div class="mb-3">
                <label>Difficulty</label>
                <select name="difficulty">
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
            <div class="mb-3"><label>Passage</label><textarea name="passage" rows="10">{{ old('passage') }}</textarea></div>
            <div class="mb-3"><label><input type="checkbox" name="is_published" value="1" checked> Published</label></div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
@endsection
