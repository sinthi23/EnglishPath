@extends('admin.layout')

@section('title', 'Edit Lesson')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header with Back Action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Edit Lesson Module</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Update study content, relative difficulty, and lecture video streams.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.lessons.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form card -->
    <div class="card">
        <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="course_id">Target Course Selection</label>
                    <select id="course_id" name="course_id">
                        <option value="">No Course Associated</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id', $lesson->course_id) == $course->id)>{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="title">Lesson Module Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $lesson->title) }}" placeholder="e.g. Introduction to Syntax structure" required autofocus>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label for="level">Lesson Level</label>
                    <select id="level" name="level">
                        <option value="beginner" @selected(old('level', $lesson->level) === 'beginner')>Beginner</option>
                        <option value="intermediate" @selected(old('level', $lesson->level) === 'intermediate')>Intermediate</option>
                        <option value="advanced" @selected(old('level', $lesson->level) === 'advanced')>Advanced</option>
                    </select>
                </div>
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner" @selected(old('difficulty', $lesson->difficulty) === 'beginner')>Beginner</option>
                        <option value="intermediate" @selected(old('difficulty', $lesson->difficulty) === 'intermediate')>Intermediate</option>
                        <option value="advanced" @selected(old('difficulty', $lesson->difficulty) === 'advanced')>Advanced</option>
                    </select>
                </div>
                <div>
                    <label for="video_url">Video Lecture URL (YouTube, Vimeo...)</label>
                    <input type="text" id="video_url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}" placeholder="e.g. https://www.youtube.com/watch?v=...">
                </div>
            </div>

            <div>
                <label for="content">Lesson Slide Content (Markdown or Plaintext)</label>
                <textarea id="content" name="content" rows="12" placeholder="Write comprehensive study material for students..." required>{{ old('content', $lesson->content) }}</textarea>
            </div>

            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" class="h-4.5 w-4.5" @checked(old('is_published', $lesson->is_published))>
                    <span class="ml-2.5 text-sm font-semibold text-slate-700 dark:text-slate-300">Published Status</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.lessons.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Update Lesson</button>
            </div>
        </form>
    </div>
</div>
@endsection
