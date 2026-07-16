@extends('admin.layout')

@section('title', 'Create Vocabulary')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header with Back Action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Add Vocabulary Word</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Insert a new dictionary word, synonyms, antonyms, and example usage.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.vocabularies.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form card -->
    <div class="card">
        <form method="POST" action="{{ route('admin.vocabularies.store') }}" class="space-y-5">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="word">Word / Term</label>
                    <input type="text" id="word" name="word" value="{{ old('word') }}" placeholder="e.g. Ephemeral" required autofocus>
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

            <div>
                <label for="meaning">Literal Meaning</label>
                <textarea id="meaning" name="meaning" rows="3" placeholder="Definition of the term..." required>{{ old('meaning') }}</textarea>
            </div>

            <div>
                <label for="example">Example Sentence</label>
                <textarea id="example" name="example" rows="3" placeholder="Contextual sentence usage demonstrating the word...">{{ old('example') }}</textarea>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="synonym">Synonyms (Comma-separated)</label>
                    <input type="text" id="synonym" name="synonym" value="{{ old('synonym') }}" placeholder="e.g. transient, fleeting">
                </div>
                <div>
                    <label for="antonym">Antonyms (Comma-separated)</label>
                    <input type="text" id="antonym" name="antonym" value="{{ old('antonym') }}" placeholder="e.g. permanent, eternal">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.vocabularies.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save Word</button>
            </div>
        </form>
    </div>
</div>
@endsection
