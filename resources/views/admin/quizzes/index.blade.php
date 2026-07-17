@extends('admin.layout')

@section('title', 'Quizzes')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Active Quizzes</h2>
            <p class="mt-1 text-xs text-slate-500">Add, edit, or configure evaluation quizzes linked to lessons and readings.</p>
        </div>
        <a class="btn btn-primary px-4.5 py-2.5 text-xs" href="{{ route('admin.quizzes.create') }}">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Quiz
        </a>
    </div>

    <!-- Table Container Card -->
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Difficulty</th>
                        <th>Passing Score</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse ($quizzes as $quiz)
                        <tr>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $quiz->title }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($quiz->difficulty) === 'beginner' ? 'beginner' : (strtolower($quiz->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $quiz->difficulty }}
                                </span>
                            </td>
                            <td class="text-slate-600 font-semibold text-xs">{{ $quiz->passing_score }}%</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a class="btn btn-secondary px-3 py-1.5 text-xs font-semibold" href="{{ route('admin.quizzes.edit', $quiz) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quiz?')">
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
                                No quizzes available. Add your first quiz above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    @if ($quizzes->hasPages())
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
            {{ $quizzes->links() }}
        </div>
    @endif
</div>
@endsection
