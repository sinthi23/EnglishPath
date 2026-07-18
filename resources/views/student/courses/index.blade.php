<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Course Catalog</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Select a course pathway to study lessons, check examples, and solve exercises.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        @if ($courses->isEmpty())
            <div class="card text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">No Courses Available</h3>
                <p class="mt-1 text-xs text-slate-500">Check back later for newly published courses from administrators.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <div class="group relative rounded-[2rem] border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.06)] hover:border-indigo-200 dark:bg-slate-900 dark:border-slate-800/60 dark:hover:border-indigo-500/30 dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.15)] flex flex-col justify-between min-h-[220px]">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-1.5">
                                    <span class="badge badge-{{ strtolower($course->level) === 'beginner' ? 'beginner' : (strtolower($course->level) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                        {{ $course->level }}
                                    </span>
                                    <span class="badge bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 font-bold border-amber-200/20">
                                        {{ $course->price > 0 ? '৳' . $course->price : 'FREE' }}
                                    </span>
                                </div>
                                <span class="text-xs font-semibold text-slate-400">
                                    {{ $course->total_lessons }} {{ Str::plural('Lesson', $course->total_lessons) }}
                                </span>
                            </div>
                            
                            <h3 class="mt-4 text-lg font-bold text-slate-955 dark:text-white leading-snug group-hover:text-indigo-650 transition dark:group-hover:text-indigo-400">
                                <a href="{{ route('student.courses.show', $course) }}">
                                    {{ $course->title }}
                                </a>
                            </h3>

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                {{ $course->description }}
                            </p>
                        </div>

                        <div class="mt-6 border-t border-slate-50 dark:border-slate-800/60 pt-4 space-y-3.5">
                            <!-- Progress Bar -->
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-400">
                                    <span>Course Progress</span>
                                    <span>{{ $course->progress_pct }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-indigo-500 h-full transition-all duration-300" style="width: {{ $course->progress_pct }}%"></div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                    {{ $course->completed_lessons }} / {{ $course->total_lessons }} Done
                                </span>
                                <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary px-5 py-2 text-xs">
                                    Enter Course
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
