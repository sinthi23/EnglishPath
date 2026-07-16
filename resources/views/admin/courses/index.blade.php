@extends('admin.layout')

@section('title', 'Courses')

@section('content')
<div class="space-y-6">
    <!-- Action and Title Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Courses Catalog</h2>
            <p class="mt-1 text-xs text-slate-500">Configure and manage English proficiency course structures.</p>
        </div>
        <a class="btn btn-primary px-4.5 py-2.5 text-xs" href="{{ route('admin.courses.create') }}">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Course
        </a>
    </div>

    <!-- Table Card Container -->
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse ($courses as $course)
                        <tr>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $course->title }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($course->level) === 'beginner' ? 'beginner' : (strtolower($course->level) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $course->level }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $course->is_published ? 'badge-published' : 'badge-draft' }}">
                                    {{ $course->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a class="btn btn-secondary px-3 py-1.5 text-xs font-semibold" href="{{ route('admin.courses.edit', $course) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?')">
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
                                No courses available. Add your first course above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    @if ($courses->hasPages())
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
