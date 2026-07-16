@extends('admin.layout')

@section('title', 'Users')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">User Accounts</h2>
            <p class="mt-1 text-xs text-slate-500">Monitor registered user profiles and manage authorization levels.</p>
        </div>
        <a class="btn btn-primary px-4.5 py-2.5 text-xs" href="{{ route('admin.users.create-admin') }}">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Add Admin
        </a>
    </div>

    <!-- Table Container Card -->
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse ($users as $user)
                        <tr>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</td>
                            <td class="text-slate-550 text-xs">{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ strtolower($user->role) === 'admin' ? 'badge-advanced bg-violet-50 text-violet-700 ring-violet-650/10 dark:bg-violet-950/30 dark:text-violet-400' : 'badge-beginner' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a class="btn btn-secondary px-3 py-1.5 text-xs font-semibold" href="{{ route('admin.users.edit', $user) }}">
                                        Edit
                                    </a>
                                    @if ($user->id !== Auth::user()->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger px-3 py-1.5 text-xs font-semibold" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-sm text-slate-400">
                                No registered users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    @if ($users->hasPages())
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
