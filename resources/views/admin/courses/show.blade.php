@extends('admin.layout')

@section('title', $course->title)

@section('content')
<div class="space-y-6">
    <!-- Header with actions -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                <a href="{{ route('admin.courses.index') }}" class="hover:text-slate-600 dark:hover:text-slate-300">Courses Catalog</a>
                <span>/</span>
                <span class="text-slate-500">Course Syllabus</span>
            </div>
            <h2 class="mt-1.5 text-xl font-extrabold tracking-tight text-slate-955 dark:text-white">{{ $course->title }}</h2>
        </div>
        <div class="flex items-center gap-2">
            <a class="btn btn-secondary text-xs px-4 py-2" href="{{ route('admin.courses.edit', $course) }}">
                Edit Course
            </a>
            <a class="btn btn-primary text-xs px-4 py-2" href="{{ route('admin.courses.index') }}">
                Back to Catalog
            </a>
        </div>
    </div>

    <!-- Course Info Card -->
    <div class="card p-6 grid gap-6 md:grid-cols-3">
        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Target Level</p>
            <span class="inline-block badge badge-{{ strtolower($course->level) === 'beginner' ? 'beginner' : (strtolower($course->level) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                {{ $course->level }}
            </span>
        </div>
        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Price</p>
            <p class="text-lg font-bold text-slate-800 dark:text-white">৳{{ $course->price }} BDT</p>
        </div>
        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Publication Status</p>
            <span class="inline-block badge {{ $course->is_published ? 'badge-published' : 'badge-draft' }}">
                {{ $course->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>
        <div class="md:col-span-3 space-y-1.5 pt-3 border-t border-slate-50 dark:border-slate-800">
            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Description</p>
            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                {{ $course->description ?? 'No description provided.' }}
            </p>
        </div>
    </div>

    <!-- Course Content Lessons Manager -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-650 dark:text-indigo-400">Lessons Syllabus ({{ $lessons->count() }})</h3>
            <a class="btn btn-secondary px-3 py-1.5 text-[11px] font-bold" href="{{ route('admin.lessons.create', ['course_id' => $course->id]) }}">
                + Add Lesson
            </a>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lesson Title</th>
                            <th>Difficulty</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse ($lessons as $index => $lesson)
                            <tr>
                                <td class="font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="font-semibold text-slate-900 dark:text-white">
                                    {{ $lesson->title }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ strtolower($lesson->difficulty) === 'beginner' ? 'beginner' : (strtolower($lesson->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                        {{ $lesson->difficulty }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $lesson->is_published ? 'badge-published' : 'badge-draft' }}">
                                        {{ $lesson->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a class="btn btn-secondary px-3 py-1.5 text-xs font-semibold" href="{{ route('admin.lessons.edit', $lesson) }}">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-sm text-slate-400">
                                    No lessons added to this course syllabus yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
