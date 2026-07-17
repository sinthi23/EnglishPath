@extends('admin.layout')

@section('title', 'Edit Quiz')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header with Back Action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Edit Quiz</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Modify settings and target metrics for this quiz.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.quizzes.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form card -->
    <div class="card">
        <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="lesson_id">Link Lesson (Optional)</label>
                    <select id="lesson_id" name="lesson_id">
                        <option value="">No Lesson Associated</option>
                        @foreach ($lessons as $lesson)
                            <option value="{{ $lesson->id }}" @selected(old('lesson_id', $quiz->lesson_id) == $lesson->id)>{{ $lesson->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="reading_passage_id">Link Reading Passage (Optional)</label>
                    <select id="reading_passage_id" name="reading_passage_id">
                        <option value="">No Passage Associated</option>
                        @foreach ($readings as $reading)
                            <option value="{{ $reading->id }}" @selected(old('reading_passage_id', $quiz->reading_passage_id) == $reading->id)>{{ $reading->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="title">Quiz Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $quiz->title) }}" placeholder="e.g. Assessment: Tenses and syntax patterns" required autofocus>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner" @selected(old('difficulty', $quiz->difficulty) === 'beginner')>Beginner</option>
                        <option value="intermediate" @selected(old('difficulty', $quiz->difficulty) === 'intermediate')>Intermediate</option>
                        <option value="advanced" @selected(old('difficulty', $quiz->difficulty) === 'advanced')>Advanced</option>
                    </select>
                </div>
                
                <div>
                    <label for="time_limit_minutes">Time Limit (Minutes)</label>
                    <input type="number" id="time_limit_minutes" name="time_limit_minutes" value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}" placeholder="e.g. 15">
                </div>

                <div>
                    <label for="passing_score">Passing Score (%)</label>
                    <input type="number" id="passing_score" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" min="0" max="100" required>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.quizzes.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Update Quiz</button>
            </div>
        </form>
    </div>

    <!-- Questions List & Addition Manager -->
    <div class="card space-y-6">
        <div class="border-b border-slate-50 dark:border-slate-850/60 pb-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Manage Quiz Questions</h3>
            <p class="text-xs text-slate-500 font-medium">Add, review, and delete assessment questions for this quiz module.</p>
        </div>

        <!-- Add Question Form -->
        <form method="POST" action="{{ route('admin.quizzes.questions.store', $quiz) }}" class="space-y-4 bg-slate-50/50 dark:bg-slate-850/20 p-5 rounded-2xl border border-slate-100 dark:border-slate-800/80">
            @csrf
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Add New Question</h4>
            
            <div>
                <label for="question">Question Text</label>
                <input type="text" id="question" name="question" placeholder="e.g. What is the synonym of 'resilience'?" required>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="option_a">Option A</label>
                    <input type="text" id="option_a" name="option_a" required>
                </div>
                <div>
                    <label for="option_b">Option B</label>
                    <input type="text" id="option_b" name="option_b" required>
                </div>
                <div>
                    <label for="option_c">Option C</label>
                    <input type="text" id="option_c" name="option_c" required>
                </div>
                <div>
                    <label for="option_d">Option D</label>
                    <input type="text" id="option_d" name="option_d" required>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="correct_answer">Correct Option</label>
                    <select id="correct_answer" name="correct_answer">
                        <option value="A">Option A</option>
                        <option value="B">Option B</option>
                        <option value="C">Option C</option>
                        <option value="D">Option D</option>
                    </select>
                </div>
                <div class="flex items-end justify-end">
                    <button class="btn btn-primary px-5 py-2.5 text-xs bg-emerald-600 hover:bg-emerald-500 border-none" type="submit">Add Question</button>
                </div>
            </div>
        </form>

        <!-- Current Questions List -->
        <div class="space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Existing Questions ({{ $quiz->questions->count() }})</h4>
            
            @if ($quiz->questions->isEmpty())
                <p class="text-xs text-slate-400 italic">No questions added to this quiz yet.</p>
            @else
                <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-slate-800">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-850/50 text-slate-400 font-bold border-b border-slate-100 dark:border-slate-800">
                                <th class="p-4">#</th>
                                <th class="p-4">Question</th>
                                <th class="p-4">Options</th>
                                <th class="p-4 text-center">Correct</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-850/60 font-medium">
                            @foreach ($quiz->questions as $index => $q)
                                <tr class="hover:bg-slate-50/30 dark:hover:bg-slate-850/20">
                                    <td class="p-4 font-bold text-slate-400">{{ $index + 1 }}</td>
                                    <td class="p-4 text-slate-900 dark:text-white max-w-xs truncate">{{ $q->question }}</td>
                                    <td class="p-4 text-slate-500">
                                        A: {{ $q->option_a }} | B: {{ $q->option_b }} | C: {{ $q->option_c }} | D: {{ $q->option_d }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="badge badge-beginner">{{ $q->correct_answer }}</span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <form method="POST" action="{{ route('admin.quizzes.questions.destroy', [$quiz, $q]) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-600 hover:underline text-[11px] font-bold" onclick="return confirm('Delete this question?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
