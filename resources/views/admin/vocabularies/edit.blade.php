@extends('admin.layout')

@section('title', 'Edit Vocabulary')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header with Back Action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Edit Vocabulary Word</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Update dictionary word configuration, example usage, or level metadata.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.vocabularies.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form card -->
    <div class="card">
        <form method="POST" action="{{ route('admin.vocabularies.update', $vocabulary) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="word">Word / Term</label>
                    <input type="text" id="word" name="word" value="{{ old('word', $vocabulary->word) }}" placeholder="e.g. Ephemeral" required autofocus>
                </div>
                
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner" @selected(old('difficulty', $vocabulary->difficulty) === 'beginner')>Beginner</option>
                        <option value="intermediate" @selected(old('difficulty', $vocabulary->difficulty) === 'intermediate')>Intermediate</option>
                        <option value="advanced" @selected(old('difficulty', $vocabulary->difficulty) === 'advanced')>Advanced</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="meaning">Literal Meaning</label>
                <textarea id="meaning" name="meaning" rows="3" placeholder="Definition of the term..." required>{{ old('meaning', $vocabulary->meaning) }}</textarea>
            </div>

            <div>
                <label for="example">Example Sentence</label>
                <textarea id="example" name="example" rows="3" placeholder="Contextual sentence usage demonstrating the word...">{{ old('example', $vocabulary->example) }}</textarea>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="synonym">Synonyms (Comma-separated)</label>
                    <input type="text" id="synonym" name="synonym" value="{{ old('synonym', $vocabulary->synonym) }}" placeholder="e.g. transient, fleeting">
                </div>
                <div>
                    <label for="antonym">Antonyms (Comma-separated)</label>
                    <input type="text" id="antonym" name="antonym" value="{{ old('antonym', $vocabulary->antonym) }}" placeholder="e.g. permanent, eternal">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.vocabularies.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Update Word</button>
            </div>
        </form>
    </div>
</div>
@endsection
