@extends('admin.layout')

@section('title', 'Lessons')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Lessons Catalog</h2>
            <p class="mt-1 text-xs text-slate-500">Edit course lesson slides, study materials, and dynamic metadata.</p>
        </div>
        <a class="btn btn-primary px-4.5 py-2.5 text-xs" href="{{ route('admin.lessons.create') }}">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Lesson
        </a>
    </div>

    <!-- Table Container Card -->
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Course</th>
                        <th>Level</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse ($lessons as $lesson)
                        <tr>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $lesson->title }}</td>
                            <td class="text-slate-500 font-medium text-xs">{{ $lesson->course?->title ?? 'No course' }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($lesson->level) === 'beginner' ? 'beginner' : (strtolower($lesson->level) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $lesson->level }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a class="btn btn-secondary px-3 py-1.5 text-xs font-semibold" href="{{ route('admin.lessons.edit', $lesson) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this lesson?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger px-3 py-1.5 text-xs font-semibold" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-sm text-slate-400">
                                No lessons available. Add your first lesson above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    @if ($lessons->hasPages())
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
            {{ $lessons->links() }}
        </div>
    @endif
</div>
@endsection
