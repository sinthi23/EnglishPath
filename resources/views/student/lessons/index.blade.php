@extends('layouts.app')

@section('title', 'Free Lessons')

@section('content')
<div class="space-y-8">
    <!-- Header banner -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-slate-900 px-8 py-10 shadow-lg dark:bg-slate-950">
        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-emerald-500/10 blur-3xl"></div>
        
        <div class="relative max-w-2xl space-y-2">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                100% Free Resources
            </span>
            <h2 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">Free Lessons Library</h2>
            <p class="text-xs text-slate-350 leading-relaxed font-medium">
                Access our library of English practice lessons. No subscription required. Grow your skills in reading, vocabulary, and grammar at your own pace.
            </p>
        </div>
    </div>

    <!-- Catalog grid -->
    <div class="space-y-6">
        <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-650 dark:text-indigo-400">Available Free Lessons ({{ $lessons->count() }})</h3>
        
        @if ($lessons->isEmpty())
            <div class="card text-center py-16 max-w-lg mx-auto">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h4 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">No Free Lessons Yet</h4>
                <p class="mt-1.5 text-xs text-slate-500">Administrators haven't published any standalone free lessons. Please check our Paid Courses catalog.</p>
                <div class="mt-5">
                    <a href="{{ route('student.courses.index') }}" class="btn btn-primary px-6 py-2.5 text-xs">Browse Premium Courses</a>
                </div>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($lessons as $lesson)
                    <div class="group relative rounded-[2rem] border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 ease-out hover:-translate-y-1.5 hover:scale-[1.01] hover:shadow-[0_20px_40px_rgba(99,102,241,0.06)] hover:border-indigo-200 dark:bg-slate-900 dark:border-slate-800/60 dark:hover:border-indigo-500/30 dark:hover:shadow-[0_20px_40px_rgba(99,102,241,0.15)] flex flex-col justify-between min-h-[200px]">
                        <div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="badge badge-{{ strtolower($lesson->difficulty) === 'beginner' ? 'beginner' : (strtolower($lesson->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $lesson->difficulty }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-450 uppercase">
                                    ● FREE
                                </span>
                            </div>
                            
                            <h3 class="mt-4 text-base font-bold text-slate-955 dark:text-white leading-snug group-hover:text-indigo-650 transition dark:group-hover:text-indigo-400">
                                <a href="{{ route('student.lessons.show', $lesson) }}">
                                    {{ $lesson->title }}
                                </a>
                            </h3>

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($lesson->content), 120) }}
                            </p>
                        </div>

                        <div class="mt-5 border-t border-slate-50 dark:border-slate-800/60 pt-4 flex items-center justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                Standalone Module
                            </span>
                            <a href="{{ route('student.lessons.show', $lesson) }}" class="btn btn-primary px-5 py-2 text-xs">
                                Start Study
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
