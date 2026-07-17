@extends('admin.layout')

@section('title', 'Create Listening Exercise')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Create Listening Exercise</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Add a new listening exercise with an audio file or remote audio link.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.listening-materials.index') }}">
            Back to Catalog
        </a>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.listening-materials.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="title">Exercise Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Intermediate Listening: Travel Vocabulary" required autofocus>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-slate-50 dark:border-slate-850/60 pt-4 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Audio Source Configuration</h4>
                <p class="text-[11px] text-slate-400 font-medium">Configure either a local MP3 file upload or a remote audio link.</p>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="audio_file">Upload Audio File (MP3/WAV/M4A)</label>
                        <input type="file" id="audio_file" name="audio_file" accept="audio/*">
                    </div>
                    
                    <div class="flex flex-col justify-end">
                        <label for="audio_url">OR Remote Audio URL</label>
                        <input type="url" id="audio_url" name="audio_url" value="{{ old('audio_url') }}" placeholder="e.g. https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.listening-materials.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save Exercise</button>
            </div>
        </form>
    </div>
</div>
@endsection
