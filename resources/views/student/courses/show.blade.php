<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    {{ $course->title }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    {{ $course->description }}
                </p>
            </div>
            <a class="btn btn-secondary text-xs px-4 py-2" href="{{ route('student.courses.index') }}">
                Back to Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-6">
            
            <!-- Success/Error Alert -->
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 text-emerald-800 dark:bg-emerald-950/20 dark:border-emerald-900/60 dark:text-emerald-300">
                    <p class="text-xs font-semibold">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="rounded-2xl border border-rose-100 bg-rose-50/50 p-4 text-rose-800 dark:bg-rose-950/20 dark:border-rose-900/60 dark:text-rose-300">
                    <p class="text-xs font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Paid Course Enrollment Card -->
            @if ($enrollment && $enrollment->status === 'pending')
                <div class="overflow-hidden rounded-[2rem] border border-amber-500/20 bg-gradient-to-br from-slate-900 via-amber-950/20 to-slate-955 p-8 text-center text-white shadow-xl max-w-2xl mx-auto my-8">
                    <div class="inline-flex items-center rounded-full border border-amber-400/20 bg-amber-500/10 px-3.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-300 mb-4 animate-pulse">
                        Enrollment Pending Verification
                    </div>
                    <h3 class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-white to-amber-100 bg-clip-text text-transparent mb-2">
                        Verification in Progress
                    </h3>
                    <p class="text-xs text-slate-350 max-w-md mx-auto leading-relaxed mb-6">
                        Your enrollment request for "{{ $course->title }}" is currently under review by our team. We are verifying your transaction.
                    </p>
                    <div class="bg-slate-950/40 rounded-xl p-4 max-w-sm mx-auto text-left text-xs border border-white/5 space-y-2 font-medium">
                        <div class="flex justify-between"><span class="text-slate-400">Payment Method:</span> <span class="text-white capitalize">{{ $enrollment->payment_method }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Transaction ID:</span> <span class="text-white font-mono">{{ $enrollment->transaction_id }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-400">Submitted at:</span> <span class="text-white">{{ $enrollment->created_at ? $enrollment->created_at->format('M d, Y H:i') : 'N/A' }}</span></div>
                    </div>
                </div>
            @elseif ($enrollment && $enrollment->status === 'rejected')
                <div class="overflow-hidden rounded-[2rem] border border-rose-500/20 bg-gradient-to-br from-slate-900 via-rose-950/20 to-slate-955 p-8 text-center text-white shadow-xl max-w-2xl mx-auto my-8">
                    <div class="inline-flex items-center rounded-full border border-rose-400/20 bg-rose-500/10 px-3.5 py-1 text-[10px] font-bold uppercase tracking-wider text-rose-350 mb-4">
                        Enrollment Request Rejected
                    </div>
                    <h3 class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-white to-rose-100 bg-clip-text text-transparent mb-2">
                        Request Declined
                    </h3>
                    <p class="text-xs text-slate-300 max-w-md mx-auto leading-relaxed mb-6">
                        Your previous enrollment request was rejected. This usually happens due to an invalid Transaction ID. Please check the details and try again.
                    </p>
                    <div class="max-w-xs mx-auto">
                        <a href="{{ route('student.courses.checkout', $course) }}" class="btn btn-primary w-full py-3.5 text-xs tracking-wider uppercase font-bold shadow-lg shadow-indigo-650/20 transition-all duration-300 hover:scale-[1.02]">
                            Submit New Request (৳{{ number_format($course->price) }} BDT)
                        </a>
                    </div>
                </div>
            @elseif (!$isEnrolled)
                <div class="overflow-hidden rounded-[2rem] border border-indigo-500/20 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-955 p-8 text-center text-white shadow-xl max-w-2xl mx-auto my-8">
                    <div class="inline-flex items-center rounded-full border border-indigo-400/20 bg-indigo-500/10 px-3.5 py-1 text-[10px] font-bold uppercase tracking-wider text-indigo-300 mb-4">
                        Premium Course
                    </div>
                    <h3 class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-white to-indigo-100 bg-clip-text text-transparent mb-2">
                        Unlock "{{ $course->title }}"
                    </h3>
                    <p class="text-xs text-slate-300 max-w-md mx-auto leading-relaxed mb-6">
                        Enroll today to get lifetime access to all lessons in this syllabus, exercises, and quizzes.
                    </p>
                    <div class="mb-6">
                        <span class="text-3xl font-black text-white">৳{{ number_format($course->price) }} BDT</span>
                        <span class="text-xs text-slate-400 font-semibold block mt-1">One-time payment</span>
                    </div>
                    <div class="max-w-xs mx-auto">
                        <a href="{{ route('student.courses.checkout', $course) }}" class="btn btn-primary w-full py-3.5 text-xs tracking-wider uppercase font-bold shadow-lg shadow-indigo-650/20 transition-all duration-300 hover:scale-[1.02]">
                            Enroll Now
                        </a>
                    </div>
                </div>
            @endif
            
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-sm font-bold uppercase tracking-wider text-indigo-650 dark:text-indigo-400">Course Syllabus & Lessons</h3>
            </div>

            @if ($lessons->isEmpty())
                <div class="card text-center py-12">
                    <p class="text-slate-500 text-sm">No lessons have been added to this course yet.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($lessons as $index => $lesson)
                        <div class="card p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 relative overflow-hidden group hover:border-indigo-150 transition">
                            <div class="flex items-start gap-4">
                                <!-- Status Indicator Icon -->
                                <div class="shrink-0 mt-1 flex h-10 w-10 items-center justify-center rounded-full {{ $lesson->completed ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-slate-50 text-slate-400 dark:bg-slate-800 dark:text-slate-500' }}">
                                    @if ($lesson->completed)
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @elseif (!$isEnrolled)
                                        <svg class="h-4 w-4 text-slate-450 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    @else
                                        <span class="text-sm font-bold">{{ $index + 1 }}</span>
                                    @endif
                                </div>

                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-base font-extrabold text-slate-900 dark:text-white leading-snug group-hover:text-indigo-650 transition">
                                            {{ $lesson->title }}
                                        </h4>
                                        <span class="badge badge-{{ strtolower($lesson->difficulty) === 'beginner' ? 'beginner' : (strtolower($lesson->difficulty) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                            {{ $lesson->difficulty }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                        {{ strip_tags($lesson->content) }}
                                    </p>
                                    @if ($lesson->completed)
                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-450 uppercase tracking-wider pt-1">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span>Completed (Best Score: {{ $lesson->score }}%)</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="shrink-0 w-full sm:w-auto">
                                @if ($isEnrolled)
                                    <a href="{{ route('student.lessons.show', $lesson) }}" class="btn {{ $lesson->completed ? 'btn-secondary' : 'btn-primary' }} w-full text-xs px-5 py-2.5">
                                        {{ $lesson->completed ? 'Review Lesson' : 'Start Lesson' }}
                                    </a>
                                @else
                                    <button class="btn btn-secondary w-full text-xs px-5 py-2.5 opacity-60 cursor-not-allowed flex items-center justify-center gap-1.5" disabled>
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Locked
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
