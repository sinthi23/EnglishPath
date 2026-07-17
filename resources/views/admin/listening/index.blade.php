@extends('admin.layout')

@section('title', 'Manage Listening Materials')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Listening Exercises Manager</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Add, update, or remove audio listening comprehensions and questions.</p>
        </div>
        <a class="btn btn-primary px-4 py-2 text-xs flex items-center gap-1.5" href="{{ route('admin.listening-materials.create') }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Add Listening Exercise
        </a>
    </div>

    @if (session('success'))
        <div id="status-alert" class="flex items-center gap-2.5 rounded-2xl border border-emerald-500/10 bg-emerald-500/5 px-4 py-2.5 text-xs font-semibold text-emerald-800 dark:text-emerald-400">
            <svg class="h-4 w-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('status-alert');
                if (alert) alert.remove();
            }, 3000);
        </script>
    @endif

    <div class="card p-0 overflow-hidden">
        @if ($materials->isEmpty())
            <div class="text-center py-12 px-6">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <h3 class="mt-4 text-sm font-bold text-slate-900 dark:text-white">No Listening Exercises Created</h3>
                <p class="mt-1 text-xs text-slate-500">Get started by creating your first audio clip exercise for students.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 font-bold border-b border-slate-100 dark:border-slate-800">
                            <th class="p-4">Title</th>
                            <th class="p-4">Audio Source</th>
                            <th class="p-4 text-center">Questions</th>
                            <th class="p-4 text-center">Difficulty</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/60 font-medium">
                        @foreach ($materials as $material)
                            <tr class="hover:bg-slate-50/30 dark:hover:bg-slate-800/25">
                                <td class="p-4 text-slate-900 dark:text-white font-bold max-w-xs truncate">{{ $material->title }}</td>
                                <td class="p-4 text-slate-500 max-w-sm truncate">
                                    <a href="{{ $material->audio_url }}" target="_blank" class="hover:underline text-sky-600 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ basename($material->audio_url) }}
                                    </a>
                                </td>
                                <td class="p-4 text-center text-slate-600 dark:text-slate-300 font-semibold">{{ $material->questions_count }}</td>
                                <td class="p-4 text-center">
                                    <span class="badge badge-{{ strtolower($material->difficulty) === 'beginner' ? 'beginner' : (strtolower($material->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                        {{ $material->difficulty }}
                                    </span>
                                </td>
                                <td class="p-4 text-right flex items-center justify-end gap-3.5">
                                    <a href="{{ route('admin.listening-materials.edit', $material) }}" class="text-sky-600 hover:text-sky-500 hover:underline font-bold">Edit / Manage Questions</a>
                                    <form method="POST" action="{{ route('admin.listening-materials.destroy', $material) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-600 hover:underline font-bold" onclick="return confirm('Delete this listening exercise?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($materials->hasPages())
                <div class="p-4 border-t border-slate-50 dark:border-slate-800/60">
                    {{ $materials->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
