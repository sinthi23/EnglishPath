@extends('admin.layout')

@section('title', 'Vocabulary')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Vocabulary Deck</h2>
            <p class="mt-1 text-xs text-slate-500">Add, edit, or remove word lists in the platform's global dictionary.</p>
        </div>
        <a class="btn btn-primary px-4.5 py-2.5 text-xs" href="{{ route('admin.vocabularies.create') }}">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Vocabulary
        </a>
    </div>

    <!-- Table Container Card -->
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Word</th>
                        <th>Meaning</th>
                        <th>Difficulty</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse ($vocabularies as $vocabulary)
                        <tr>
                            <td class="font-bold text-slate-900 dark:text-white capitalize">{{ $vocabulary->word }}</td>
                            <td class="text-slate-600 font-medium text-xs leading-relaxed max-w-sm truncate">{{ $vocabulary->meaning }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($vocabulary->difficulty) === 'beginner' ? 'beginner' : (strtolower($vocabulary->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                    {{ $vocabulary->difficulty }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a class="btn btn-secondary px-3 py-1.5 text-xs font-semibold" href="{{ route('admin.vocabularies.edit', $vocabulary) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.vocabularies.destroy', $vocabulary) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this vocabulary item?')">
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
                                No vocabulary terms available. Add your first term above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    @if ($vocabularies->hasPages())
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
            {{ $vocabularies->links() }}
        </div>
    @endif
</div>
@endsection
