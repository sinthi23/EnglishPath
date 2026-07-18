<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Listening Lab</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Play audio passages, evaluate your comprehension, and track your scores.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        @if ($materials->isEmpty())
            <div class="card text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <h3 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">No Listening Exercises Created</h3>
                <p class="mt-1 text-xs text-slate-500">Administrators haven't added any listening audio modules yet.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($materials as $material)
                    <div class="group relative rounded-[2rem] border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.06)] hover:border-indigo-200 dark:bg-slate-900 dark:border-slate-800/60 dark:hover:border-indigo-500/30 dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.15)] flex flex-col justify-between min-h-[220px]">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="badge badge-{{ strtolower($material->difficulty) === 'beginner' ? 'beginner' : (strtolower($material->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $material->difficulty }}
                                </span>
                                <span class="text-xs font-semibold text-slate-400">
                                    {{ $material->questions_count }} {{ Str::plural('Question', $material->questions_count) }}
                                </span>
                            </div>
                            
                            <h3 class="mt-4 text-base font-bold text-slate-950 dark:text-white leading-snug group-hover:text-indigo-650 transition dark:group-hover:text-indigo-400">
                                {{ $material->title }}
                            </h3>

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Audio Guide
                            </p>
                        </div>

                        <div class="mt-6 border-t border-slate-50 dark:border-slate-800/60 pt-4 flex items-center justify-between">
                            <div>
                                @if ($material->completed)
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Best Score</span>
                                        <span class="text-xs font-extrabold text-indigo-650 dark:text-indigo-400">
                                            {{ $material->score }}%
                                        </span>
                                    </div>
                                @else
                                    <span class="text-[11px] font-semibold text-slate-400">Not attempted</span>
                                @endif
                            </div>
                            
                            <a href="{{ route('student.listening.show', $material) }}" class="btn btn-primary px-4.5 py-2 text-xs">
                                {{ $material->completed ? 'Retake' : 'Play & Practice' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
