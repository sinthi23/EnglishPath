<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    {{ $quiz->title }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Difficulty: <span class="capitalize font-bold">{{ $quiz->difficulty }}</span> | Passing Score: {{ $quiz->passing_score }}%
                </p>
            </div>
            @if ($quiz->time_limit_minutes)
                <div class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-4 py-2 text-xs font-bold text-rose-700 dark:bg-rose-950/40 dark:text-rose-450 animate-pulse">
                    Timer: {{ $quiz->time_limit_minutes }} Minutes
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-8">
            <div class="card">
                <div class="border-b border-slate-50 dark:border-slate-800/60 pb-5">
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Assessment Questions</h3>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Read each question carefully and select the best matching answer option.</p>
                </div>

                <form method="POST" action="{{ route('student.quizzes.submit', $quiz) }}" class="mt-8 space-y-8">
                    @csrf
                    
                    @foreach ($quiz->questions as $index => $question)
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white flex items-start gap-2.5">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-xs font-extrabold text-indigo-650 dark:text-indigo-400">
                                    {{ $index + 1 }}
                                </span>
                                <span class="leading-6">{{ $question->question }}</span>
                            </h4>

                            <div class="grid gap-3.5 sm:grid-cols-2 pl-8.5">
                                @foreach (['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d'] as $key => $optionField)
                                    <label class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50/50 p-4 text-xs font-semibold text-slate-700 dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-200 cursor-pointer hover:bg-slate-100/50 dark:hover:bg-slate-800/60 transition normal-case tracking-normal mb-0">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="h-4.5 w-4.5 border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-900 dark:border-slate-800" required>
                                        <span>{{ $question->$optionField }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-6 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-between">
                        @if ($quiz->lesson_id)
                            <a class="btn btn-secondary text-xs" href="{{ route('student.lessons.show', $quiz->lesson_id) }}">
                                Back to Lesson
                            </a>
                        @elseif ($quiz->reading_passage_id)
                            <a class="btn btn-secondary text-xs" href="{{ route('student.readings.show', $quiz->reading_passage_id) }}">
                                Back to Reading
                            </a>
                        @else
                            <a class="btn btn-secondary text-xs" href="{{ route('student.dashboard') }}">
                                Cancel
                            </a>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            Submit Quiz Answers
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
