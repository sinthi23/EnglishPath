<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    {{ $writingTopic->title }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Difficulty: <span class="capitalize font-bold">{{ $writingTopic->difficulty }}</span> | Required Length: {{ $writingTopic->min_words }} words
                </p>
            </div>
            <a class="btn btn-secondary text-xs px-4 py-2" href="{{ route('student.writing.index') }}">
                Back to Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-6">
            <!-- Guidelines/Prompt Card -->
            <div class="card space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-650 dark:text-indigo-400">Guidelines</h3>
                </div>
                <p class="text-sm leading-relaxed text-slate-700 dark:text-slate-300 whitespace-pre-line font-medium">
                    {{ $writingTopic->prompt }}
                </p>
            </div>

            <!-- Editor Card -->
            <div class="card space-y-5">
                <form method="POST" action="{{ route('student.writing.submit', $writingTopic) }}" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="editor" class="text-slate-400">Your Response</label>
                        <textarea id="editor" name="content" rows="12" 
                            class="w-full rounded-[1.5rem] border border-slate-200 bg-white p-5 text-sm text-slate-800 shadow-sm transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 dark:border-slate-800 dark:bg-slate-950 dark:text-white dark:focus:border-indigo-500 dark:focus:ring-indigo-950/40 leading-relaxed font-sans"
                            placeholder="Begin writing your response here..." required>{{ old('content', $latestSubmission?->content) }}</textarea>
                    </div>

                    <!-- Statistics bar -->
                    <div class="flex flex-wrap items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800/80 rounded-2xl p-4 text-xs font-semibold">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-400">Word Count:</span>
                            <span id="word-count" class="text-rose-600 dark:text-rose-455 font-bold">0</span>
                            <span class="text-slate-300">/</span>
                            <span class="text-slate-500">{{ $writingTopic->min_words }} words target</span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full sm:w-48 bg-slate-200 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div id="word-progress" class="bg-rose-500 h-full w-0 transition-all duration-300"></div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span id="word-badge" class="badge bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-455">Under Target</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end">
                        <button type="submit" id="submit-btn" class="btn btn-primary px-6 py-3 bg-indigo-600 hover:bg-indigo-500 border-none">
                            Submit Response
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Counter and Progress Visualizer -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editor = document.getElementById('editor');
            const wordCounter = document.getElementById('word-count');
            const progress = document.getElementById('word-progress');
            const badge = document.getElementById('word-badge');
            const targetWords = parseInt("{{ $writingTopic->min_words }}");

            function updateCounts() {
                const text = editor.value.trim();
                const words = text ? text.split(/\s+/) : [];
                const wordCount = words.length;

                wordCounter.textContent = wordCount;

                // Update progress percentage
                const pct = Math.min(100, Math.round((wordCount / targetWords) * 100));
                progress.style.width = pct + '%';

                if (wordCount >= targetWords) {
                    // Turn green (Met target)
                    wordCounter.className = 'text-emerald-600 dark:text-emerald-400 font-bold';
                    progress.className = 'bg-emerald-500 h-full transition-all duration-300';
                    badge.textContent = 'Target Met';
                    badge.className = 'badge bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400';
                } else {
                    // Keep red/rose (Under target)
                    wordCounter.className = 'text-rose-600 dark:text-rose-455 font-bold';
                    progress.className = 'bg-rose-500 h-full transition-all duration-300';
                    badge.textContent = 'Under Target';
                    badge.className = 'badge bg-rose-50 text-rose-700 dark:bg-rose-950/30 dark:text-rose-455';
                }
            }

            editor.addEventListener('input', updateCounts);
            updateCounts(); // Initial run on page load
        });
    </script>
</x-app-layout>
