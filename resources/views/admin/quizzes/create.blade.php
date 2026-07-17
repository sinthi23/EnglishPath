@extends('admin.layout')

@section('title', 'Create Quiz')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header with Back Action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Create Quiz</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Add evaluation questionnaires linked to lesson guides or comprehension items.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.quizzes.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form card -->
    <div class="card">
        <form method="POST" action="{{ route('admin.quizzes.store') }}" class="space-y-5">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="lesson_id">Link Lesson (Optional)</label>
                    <select id="lesson_id" name="lesson_id">
                        <option value="">No Lesson Associated</option>
                        @foreach ($lessons as $lesson)
                            <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="reading_passage_id">Link Reading Passage (Optional)</label>
                    <select id="reading_passage_id" name="reading_passage_id">
                        <option value="">No Passage Associated</option>
                        @foreach ($readings as $reading)
                            <option value="{{ $reading->id }}">{{ $reading->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="title">Quiz Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Assessment: Tenses and syntax patterns" required autofocus>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                
                <div>
                    <label for="time_limit_minutes">Time Limit (Minutes)</label>
                    <input type="number" id="time_limit_minutes" name="time_limit_minutes" value="{{ old('time_limit_minutes') }}" placeholder="e.g. 15">
                </div>

                <div>
                    <label for="passing_score">Passing Score (%)</label>
                    <input type="number" id="passing_score" name="passing_score" value="50" min="0" max="100" required>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.quizzes.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save Quiz</button>
            </div>
        </form>
    </div>
</div>
@endsection
