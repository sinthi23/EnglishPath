<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Quiz Assessment Results
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    {{ $quiz->title }}
                </p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold {{ $score >= $quiz->passing_score ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300' }}">
                {{ $score >= $quiz->passing_score ? 'PASSED' : 'TRY AGAIN' }}
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-8">
        <div class="mx-auto max-w-4xl space-y-8">
            <!-- Score Card -->
            <div class="card overflow-hidden relative flex flex-col justify-between">
                <div class="flex flex-col items-center justify-center text-center p-6 sm:p-10">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Final Assessment Score</p>
                    
                    <div class="relative mt-6 flex items-center justify-center">
                        <span class="text-6xl font-extrabold {{ $score >= $quiz->passing_score ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ $score }}%
                        </span>
                    </div>

                    <div class="w-full max-w-md mt-6">
                        <div class="h-2.5 rounded-full bg-slate-100 dark:bg-slate-800">
                            <div class="h-2.5 rounded-full {{ $score >= $quiz->passing_score ? 'bg-emerald-500' : 'bg-rose-500' }}" style="width: {{ $score }}%"></div>
                        </div>
                    </div>

                    <h3 class="mt-8 text-xl font-extrabold text-slate-900 dark:text-white">
                        @if ($score >= $quiz->passing_score)
                            Congratulations! You passed the assessment.
                        @else
                            Keep practicing! You did not reach the passing score of {{ $quiz->passing_score }}%.
                        @endif
                    </h3>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        You answered {{ $correctCount }} out of {{ $totalCount }} questions correctly.
                    </p>
                </div>
            </div>

            <!-- Graded Review List -->
            <div class="card">
                <div class="border-b border-slate-50 dark:border-slate-800/60 pb-5">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Assessment Review</h3>
                    <p class="mt-1 text-xs text-slate-555 dark:text-slate-400">Review your choices and study correct definitions below.</p>
                </div>

                <div class="mt-8 space-y-8">
                    @foreach ($gradedQuestions as $index => $item)
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white flex items-start gap-2.5">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-xs font-extrabold text-indigo-650 dark:text-indigo-400">
                                    {{ $index + 1 }}
                                </span>
                                <span class="leading-6">{{ $item['question']->question }}</span>
                            </h4>

                            <div class="grid gap-3.5 sm:grid-cols-2 pl-8.5">
                                @foreach (['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d'] as $key => $optionField)
                                    @php
                                        $submitted = strtoupper($item['submitted']) === $key;
                                        $correct = strtoupper($item['correct']) === $key;
                                        $bgClass = 'bg-slate-50/50 border-slate-100 dark:border-slate-800 dark:bg-slate-800/40';
                                        $textClass = 'text-slate-700 dark:text-slate-300';
                                        
                                        if ($submitted && $correct) {
                                            $bgClass = 'bg-emerald-50/40 border-emerald-250 text-emerald-800 dark:bg-emerald-950/20 dark:border-emerald-900/60';
                                            $textClass = 'text-emerald-800 dark:text-emerald-300 font-bold';
                                        } elseif ($submitted && !$correct) {
                                            $bgClass = 'bg-rose-50/40 border-rose-250 text-rose-800 dark:bg-rose-950/20 dark:border-rose-900/60';
                                            $textClass = 'text-rose-800 dark:text-rose-300 font-bold';
                                        } elseif ($correct) {
                                            $bgClass = 'bg-emerald-50/20 border-emerald-100 text-emerald-700 dark:bg-emerald-950/10 dark:border-emerald-900/40';
                                            $textClass = 'text-emerald-700 dark:text-emerald-400';
                                        }
                                    @endphp
                                    
                                    <div class="flex items-center gap-3 rounded-2xl border p-4 text-xs font-semibold {{ $bgClass }} {{ $textClass }}">
                                        <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border text-[10px] font-extrabold 
                                            {{ $correct ? 'bg-emerald-500 border-emerald-500 text-white' : ($submitted ? 'bg-rose-500 border-rose-500 text-white' : 'border-slate-300 text-slate-400') }}">
                                            {{ $key }}
                                        </div>
                                        <span>{{ $item['question']->$optionField }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-between pt-4">
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
                        Back to Dashboard
                    </a>
                @endif
                
                <a class="btn btn-primary" href="{{ route('student.dashboard') }}">
                    Finish Assessment
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
