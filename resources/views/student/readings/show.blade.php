<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('student.readings.index') }}" class="text-xs font-bold text-indigo-600 hover:underline dark:text-indigo-400">Reading Catalog</a>
                    <span class="text-xs text-slate-400">/</span>
                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Passage View</span>
                </div>
                <h2 class="mt-1.5 text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">{{ $reading->title }}</h2>
            </div>
            <div class="inline-flex items-center gap-2 rounded-full bg-slate-50 border border-slate-200/80 px-4 py-2 text-xs font-bold text-slate-700 dark:bg-slate-900 dark:border-slate-800 dark:text-slate-300">
                Difficulty: <span class="badge badge-{{ strtolower($reading->difficulty) === 'beginner' ? 'beginner' : (strtolower($reading->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }} ml-1.5">{{ $reading->difficulty }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-8">
        <div class="mx-auto max-w-5xl space-y-8">
            <!-- Reading Passage Block -->
            <div class="rounded-[2.25rem] border border-slate-100 bg-white p-6 sm:p-10 shadow-sm dark:bg-slate-900 dark:border-slate-800/60">
                <div class="flex items-center gap-2">
                    <span class="badge badge-{{ strtolower($reading->difficulty) === 'beginner' ? 'beginner' : (strtolower($reading->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                        {{ $reading->difficulty }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400">Comprehension Practice</span>
                </div>
                
                <h3 class="mt-4 text-3xl font-extrabold text-slate-950 dark:text-white tracking-tight">{{ $reading->title }}</h3>
                
                <div class="mt-8 text-sm leading-8 text-slate-700 dark:text-slate-300 whitespace-pre-line prose max-w-none dark:prose-invert">
                    {!! nl2br(e($reading->passage)) !!}
                </div>
            </div>

            <!-- Quiz / Score Details -->
            @if ($quiz)
                <div class="space-y-6">
                    @if ($latestProgress?->score !== null)
                        <div class="rounded-[2rem] border border-emerald-100 bg-emerald-50/20 p-6 dark:bg-emerald-950/10 dark:border-emerald-900/60 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-emerald-900 dark:text-emerald-300">You've completed this passage quiz!</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Practice makes perfect. You can retake the quiz below at any time to raise your grade.</p>
                            </div>
                            <div class="rounded-2xl border border-emerald-100 bg-white px-5 py-3.5 text-center shadow-sm dark:bg-slate-900 dark:border-emerald-950">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-450">Previous Score</p>
                                <p class="mt-1 text-3xl font-extrabold text-emerald-700 dark:text-emerald-400">
                                    {{ $latestProgress->score }}%
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Quiz Form Card -->
                    <div class="rounded-[2.25rem] border border-slate-100 bg-white p-6 sm:p-10 shadow-sm dark:bg-slate-900 dark:border-slate-800/60">
                        <div class="border-b border-slate-50 dark:border-slate-800/60 pb-5">
                            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Comprehension Quiz</h3>
                            <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">Answer these questions carefully based on the reading text above.</p>
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

                            <div class="pt-6 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end">
                                <button type="submit" class="btn btn-primary">
                                    Submit Quiz Answers
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-200/80 p-8 text-center text-sm text-slate-400 dark:border-slate-800 dark:text-slate-500">
                    No comprehension questions are available for this reading passage.
                </div>
            @endif

            <!-- Navigation actions -->
            <div class="flex items-center justify-between pt-4">
                <a class="btn btn-secondary" href="{{ route('student.readings.index') }}">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Readings
                </a>
                <a class="btn btn-secondary" href="{{ route('student.dashboard') }}">
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
