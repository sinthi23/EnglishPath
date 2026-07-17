@extends('admin.layout')

@section('title', 'Create Writing Topic')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Create Writing Topic</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Add a new writing topic and instructions for students.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.writing-topics.index') }}">
            Back to Catalog
        </a>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.writing-topics.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="title">Topic Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. My Future Career Aspirations" required autofocus>
            </div>

            <div>
                <label for="prompt">Writing Prompt / Guidelines</label>
                <textarea id="prompt" name="prompt" rows="5" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100 dark:border-slate-800 dark:bg-slate-950 dark:text-white dark:focus:border-sky-500 dark:focus:ring-sky-950/40" placeholder="Describe the topic details, questions to answer, and writing guidelines..." required>{{ old('prompt') }}</textarea>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="min_words">Minimum Word Count Required</label>
                    <input type="number" id="min_words" name="min_words" value="{{ old('min_words', 50) }}" min="10" required>
                </div>
                
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.writing-topics.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save Topic</button>
            </div>
        </form>
    </div>
</div>
@endsection
