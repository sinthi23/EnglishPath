@extends('admin.layout')

@section('title', 'Edit Reading')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header with Back Action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Edit Reading Passage</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Update the essay contents, relative level, and publish status of this passage.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.readings.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form card -->
    <div class="card">
        <form method="POST" action="{{ route('admin.readings.update', $readingPassage) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="title">Passage Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $readingPassage->title) }}" placeholder="e.g. The impact of industrial revolution" required autofocus>
                </div>
                
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner" @selected(old('difficulty', $readingPassage->difficulty) === 'beginner')>Beginner</option>
                        <option value="intermediate" @selected(old('difficulty', $readingPassage->difficulty) === 'intermediate')>Intermediate</option>
                        <option value="advanced" @selected(old('difficulty', $readingPassage->difficulty) === 'advanced')>Advanced</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="passage">Passage Text Content</label>
                <textarea id="passage" name="passage" rows="12" placeholder="Write or paste the full passage essay content..." required>{{ old('passage', $readingPassage->passage) }}</textarea>
            </div>

            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" class="h-4.5 w-4.5" @checked(old('is_published', $readingPassage->is_published))>
                    <span class="ml-2.5 text-sm font-semibold text-slate-700 dark:text-slate-300">Published Status</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.readings.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Update Passage</button>
            </div>
        </form>
    </div>
</div>
@endsection
