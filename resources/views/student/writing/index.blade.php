<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Writing Practice</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Select a topic, write your response, and receive detailed score analytics instantly.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        @if ($topics->isEmpty())
            <div class="card text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <h3 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">No Writing Topics Created</h3>
                <p class="mt-1 text-xs text-slate-500">Administrators haven't added any writing prompts yet.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($topics as $topic)
                    <div class="group relative rounded-[2rem] border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.06)] hover:border-indigo-200 dark:bg-slate-900 dark:border-slate-800/60 dark:hover:border-indigo-500/30 dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.15)] flex flex-col justify-between min-h-[220px]">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="badge badge-{{ strtolower($topic->difficulty) === 'beginner' ? 'beginner' : (strtolower($topic->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $topic->difficulty }}
                                </span>
                                <span class="text-xs font-semibold text-slate-400">Min: {{ $topic->min_words }} words</span>
                            </div>
                            
                            <h3 class="mt-4 text-base font-bold text-slate-950 dark:text-white leading-snug group-hover:text-indigo-650 transition dark:group-hover:text-indigo-400">
                                {{ $topic->title }}
                            </h3>

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                {{ strip_tags($topic->prompt) }}
                            </p>
                        </div>

                        <div class="mt-6 border-t border-slate-50 dark:border-slate-800/60 pt-4 flex items-center justify-between">
                            <div>
                                @if ($topic->completed)
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Best Score</span>
                                        <span class="text-xs font-extrabold text-indigo-650 dark:text-indigo-400">
                                            {{ $topic->score }}%
                                        </span>
                                    </div>
                                @else
                                    <span class="text-[11px] font-semibold text-slate-400">Not attempted</span>
                                @endif
                            </div>
                            
                            <a href="{{ route('student.writing.show', $topic) }}" class="btn btn-primary px-4.5 py-2 text-xs">
                                {{ $topic->completed ? 'Rewrite' : 'Start Writing' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
