<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Evaluation Results
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Review your writing performance statistics and constructive feedback below.
                </p>
            </div>
            <a class="btn btn-secondary text-xs px-4 py-2" href="{{ route('student.writing.index') }}">
                Back to Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-6">
            
            <!-- Summary card with overall score -->
            <div class="card bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-950 text-white border-slate-800/80 p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
                <div class="space-y-2.5 text-center md:text-left">
                    <span class="badge bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Grades Calculated</span>
                    <h3 class="text-xl font-extrabold">{{ $submission->topic->title }}</h3>
                    <p class="text-xs text-slate-400 font-medium">Submitted on {{ $submission->completed_at->format('M d, Y \a\t h:i A') }}</p>
                </div>

                <!-- Glow Score Meter -->
                <div class="flex flex-col items-center justify-center shrink-0">
                    <div class="relative flex h-28 w-28 items-center justify-center rounded-full bg-slate-900 border-4 border-indigo-500/30 shadow-[0_0_30px_rgba(99,102,241,0.2)]">
                        <div class="text-center">
                            <span class="text-3xl font-black text-indigo-400">{{ $submission->overall_score }}</span>
                            <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">Overall</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Score breakdown grid -->
            <div class="grid gap-6 sm:grid-cols-3">
                <!-- Length Score Card -->
                <div class="card space-y-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Response Length</span>
                        <span class="text-sm font-extrabold text-slate-900 dark:text-white">{{ $submission->length_score }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-sky-500 rounded-full" style="width: {{ $submission->length_score }}%"></div>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Evaluates your output relative to the target word limit requirements.</p>
                </div>

                <!-- Grammar Score Card -->
                <div class="card space-y-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Grammar & Structure</span>
                        <span class="text-sm font-extrabold text-slate-900 dark:text-white">{{ $submission->grammar_score }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $submission->grammar_score }}%"></div>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Grades structure compliance, sentence boundaries, and punctuation usage.</p>
                </div>

                <!-- Vocabulary Score Card -->
                <div class="card space-y-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Vocabulary Variety</span>
                        <span class="text-sm font-extrabold text-slate-900 dark:text-white">{{ $submission->vocabulary_score }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ $submission->vocabulary_score }}%"></div>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Analyzes lexical diversity, advanced wording levels, and phrasing variety.</p>
                </div>
            </div>

            <!-- Feedback list -->
            <div class="card space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-650 dark:text-indigo-400">Feedback and Recommendations</h3>
                </div>
                <div class="text-sm text-slate-700 dark:text-slate-300 font-medium whitespace-pre-line leading-relaxed">
                    {{ $submission->feedback }}
                </div>
            </div>

            <!-- Your Text display -->
            <div class="card space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Submitted Essay</h3>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-6 dark:bg-slate-950/30 dark:border-slate-800/80 text-sm leading-relaxed text-slate-800 dark:text-slate-300 whitespace-pre-wrap font-sans font-medium">
                    {{ $submission->content }}
                </div>
            </div>

            <div class="flex items-center justify-center">
                <a class="btn btn-secondary px-8 py-3 rounded-2xl" href="{{ route('student.writing.index') }}">
                    Return to Writing Catalog
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
