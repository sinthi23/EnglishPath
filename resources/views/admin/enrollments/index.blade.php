@extends('admin.layout')

@section('title', 'Enrollment Requests')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Enrollment Requests</h2>
        <p class="mt-1 text-xs text-slate-500">Verify transaction IDs and approve or reject premium course access.</p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
        <a href="{{ route('admin.enrollments.index', ['status' => 'pending']) }}" 
           class="rounded-full px-4 py-2 text-xs font-bold transition {{ $status === 'pending' ? 'bg-sky-500 text-white shadow' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-350 dark:hover:bg-slate-750' }}">
            Pending Approval ({{ \App\Models\Enrollment::where('status', 'pending')->count() }})
        </a>
        <a href="{{ route('admin.enrollments.index', ['status' => 'approved']) }}" 
           class="rounded-full px-4 py-2 text-xs font-bold transition {{ $status === 'approved' ? 'bg-emerald-500 text-white shadow' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-350 dark:hover:bg-slate-750' }}">
            Approved ({{ \App\Models\Enrollment::where('status', 'approved')->count() }})
        </a>
        <a href="{{ route('admin.enrollments.index', ['status' => 'rejected']) }}" 
           class="rounded-full px-4 py-2 text-xs font-bold transition {{ $status === 'rejected' ? 'bg-rose-500 text-white shadow' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 dark:bg-slate-800 dark:text-slate-350 dark:hover:bg-slate-750' }}">
            Rejected ({{ \App\Models\Enrollment::where('status', 'rejected')->count() }})
        </a>
    </div>

    <!-- Requests Table -->
    <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Submitted At</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    @forelse ($enrollments as $enrollment)
                        <tr>
                            <td>
                                <div class="space-y-0.5">
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $enrollment->user->name }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $enrollment->user->email }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="space-y-0.5">
                                    <div class="font-semibold text-slate-850 dark:text-slate-200">{{ $enrollment->course->title }}</div>
                                    <div class="text-[10px] font-bold text-slate-500">Price: ৳{{ number_format($enrollment->course->price) }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-intermediate uppercase text-[10px]">
                                    {{ $enrollment->payment_method ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="font-mono font-bold text-slate-800 dark:text-slate-300">
                                    {{ $enrollment->transaction_id ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs text-slate-500 font-medium">
                                    {{ $enrollment->created_at ? $enrollment->created_at->format('M d, Y H:i') : 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    @if ($enrollment->status === 'pending')
                                        <form action="{{ route('admin.enrollments.approve', $enrollment) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white px-3.5 py-1.5 text-xs font-bold rounded-xl transition shadow-sm shadow-emerald-500/10" type="submit">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.enrollments.reject', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Reject enrollment for {{ $enrollment->user->email }}?')">
                                            @csrf
                                            <button class="btn bg-rose-500 hover:bg-rose-600 text-white px-3.5 py-1.5 text-xs font-bold rounded-xl transition shadow-sm shadow-rose-500/10" type="submit">
                                                Reject
                                            </button>
                                        </form>
                                    @elseif ($enrollment->status === 'approved')
                                        <form action="{{ route('admin.enrollments.reject', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Revoke/Reject enrollment for {{ $enrollment->user->email }}?')">
                                            @csrf
                                            <button class="btn btn-danger px-3.5 py-1.5 text-xs font-semibold rounded-xl" type="submit">
                                                Reject Access
                                            </button>
                                        </form>
                                    @elseif ($enrollment->status === 'rejected')
                                        <form action="{{ route('admin.enrollments.approve', $enrollment) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="btn bg-emerald-500 hover:bg-emerald-600 text-white px-3.5 py-1.5 text-xs font-bold rounded-xl transition" type="submit">
                                                Approve Access
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-sm text-slate-450 dark:text-slate-500">
                                No enrollment requests found with status: <span class="capitalize font-bold">{{ $status }}</span>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($enrollments->hasPages())
        <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
            {{ $enrollments->appends(['status' => $status])->links() }}
        </div>
    @endif
</div>
@endsection
