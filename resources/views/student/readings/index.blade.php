<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Reading Practice Passages
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Read passages and answer comprehension questions to build your comprehension skills.
                </p>
            </div>
            <div class="rounded-full bg-indigo-50 px-4 py-2 text-xs font-bold text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-400">
                {{ $passages->total() }} Reading Passages
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-8">
        @if ($passages->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-200 p-12 text-center text-slate-400 dark:border-slate-800 dark:text-slate-500">
                <p class="text-sm font-semibold">No reading passages available.</p>
                <p class="mt-1.5 text-xs">Create reading passages in the Admin panel to populate this page.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($passages as $passage)
                    <div class="card relative flex flex-col justify-between group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="badge badge-{{ strtolower($passage->difficulty) === 'beginner' ? 'beginner' : (strtolower($passage->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $passage->difficulty }}
                                </span>
                                @if ($passage->quiz)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-450 uppercase">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Quiz Available
                                    </span>
                                @endif
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white line-clamp-1 group-hover:text-indigo-650 transition">
                                    {{ $passage->title }}
                                </h3>
                                <p class="mt-2 text-xs text-slate-455 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                    {{ Str::limit(strip_tags($passage->passage), 120) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-slate-50 dark:border-slate-800/60 pt-4 flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-400">Length: <span class="text-slate-600 dark:text-slate-300">{{ str_word_count(strip_tags($passage->passage)) }} words</span></span>
                            <a href="{{ route('student.readings.show', $passage) }}" class="btn btn-primary px-4 py-2 text-xs">
                                Start Reading
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                {{ $passages->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
