<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Listening Assessment Summary
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Review your performance details and questions evaluation breakdown below.
                </p>
            </div>
            <a class="btn btn-secondary text-xs px-4 py-2" href="{{ route('student.listening.index') }}">
                Back to Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-6">
            
            <!-- Result Summary banner -->
            <div class="card bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-950 text-white border-slate-800/80 p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="space-y-2.5 text-center md:text-left">
                    <span class="badge bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Grades Calculated</span>
                    <h3 class="text-xl font-extrabold">{{ $listeningMaterial->title }}</h3>
                    <p class="text-xs text-slate-400 font-medium">Completed on {{ $attempt->completed_at->format('M d, Y \a\t h:i A') }}</p>
                </div>

                <!-- Glow Score Meter -->
                <div class="flex flex-col items-center justify-center shrink-0">
                    <div class="relative flex h-28 w-28 items-center justify-center rounded-full bg-slate-900 border-4 border-indigo-500/30 shadow-[0_0_30px_rgba(99,102,241,0.2)]">
                        <div class="text-center">
                            <span class="text-3xl font-black text-indigo-400">{{ $score }}%</span>
                            <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">Score</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Analysis Cards -->
            <div class="card space-y-6">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Question Breakdown</h3>
                </div>

                <div class="space-y-6">
                    @foreach ($gradedQuestions as $index => $graded)
                        <div class="space-y-3.5">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white flex items-start gap-2.5">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-xs font-extrabold {{ $graded['is_correct'] ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-455' }}">
                                    {{ $index + 1 }}
                                </span>
                                <span class="leading-6">{{ $graded['question']->question }}</span>
                            </h4>

                            <div class="grid gap-3 sm:grid-cols-2 pl-8.5">
                                @foreach (['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d'] as $key => $field)
                                    @php
                                        $isSubmitted = ($graded['submitted'] === $key);
                                        $isCorrect = ($graded['correct'] === $key);
                                        
                                        $class = 'border-slate-100 bg-slate-50/50 text-slate-700 dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-200';
                                        if ($isSubmitted) {
                                            $class = $isCorrect
                                                ? 'border-emerald-500 bg-emerald-50/30 text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-950/30 dark:text-emerald-400'
                                                : 'border-rose-500 bg-rose-50/30 text-rose-700 dark:border-rose-500/30 dark:bg-rose-950/30 dark:text-rose-455';
                                        } elseif ($isCorrect) {
                                            $class = 'border-emerald-500 bg-emerald-50/10 text-emerald-600 dark:border-emerald-500/20 dark:bg-emerald-950/10 dark:text-emerald-450';
                                        }
                                    @endphp
                                    <div class="flex items-center gap-3 rounded-2xl border p-4 text-xs font-semibold {{ $class }}">
                                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full text-[10px] font-black {{ $isSubmitted ? ($isCorrect ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white') : 'bg-slate-200 text-slate-700 dark:bg-slate-850 dark:text-slate-300' }}">
                                            {{ $key }}
                                        </span>
                                        <span class="flex-1">{{ $graded['question']->$field }}</span>
                                        @if ($isSubmitted)
                                            <span class="text-[10px] font-bold uppercase tracking-wider">
                                                {{ $isCorrect ? 'Correct' : 'Your Answer' }}
                                            </span>
                                        @elseif ($isCorrect)
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-450">
                                                Correct Answer
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-center">
                <a class="btn btn-secondary px-8 py-3 rounded-2xl" href="{{ route('student.listening.index') }}">
                    Return to Listening Catalog
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
