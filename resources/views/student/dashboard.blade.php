<x-app-layout>
	<x-slot name="header">
		<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
			<div>
				<h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
					Student Dashboard
				</h2>
				<p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
					Track your lesson progress, bookmarks, vocabulary growth, and recent quiz activity.
				</p>
				<p class="mt-2 text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
					<svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
					</svg>
					Logged in as: <span class="font-semibold text-indigo-650 dark:text-indigo-400">{{ auth()->user()->email }}</span>
				</p>
			</div>
			<div class="inline-flex items-center gap-2.5 rounded-full bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-300">
				<span class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
				{{ $overallProgress }}% Overall Progress
			</div>
		</div>
	</x-slot>

	<div class="py-6 space-y-8">
		<!-- Main Stat Cards Grid -->
		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
			<!-- Current Lesson -->
			<div class="group rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100 transition duration-300 hover:shadow-md hover:ring-slate-200/80 dark:bg-slate-900 dark:ring-slate-800">
				<div class="flex items-center justify-between">
					<p class="text-xs font-bold uppercase tracking-wider text-slate-400">Current Lesson</p>
					<span class="rounded-xl bg-sky-50 p-2 text-sky-600 dark:bg-sky-950/30 dark:text-sky-400">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.08 1.477 4.5 2.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 2.253" />
						</svg>
					</span>
				</div>
				<p class="mt-4 text-lg font-bold text-slate-800 dark:text-white line-clamp-1 group-hover:text-indigo-650 transition">
					{{ $currentLesson?->title ?? 'No lesson selected' }}
				</p>
				@if ($currentLesson)
					<a class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400" href="{{ route('student.lessons.show', $currentLesson) }}">
						<span>Open lesson</span>
						<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
						</svg>
					</a>
				@else
					<a class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400" href="{{ route('student.lessons.index') }}">
						<span>Browse lessons</span>
						<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
						</svg>
					</a>
				@endif
			</div>

			<!-- Quiz Score -->
			<div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100 dark:bg-slate-900 dark:ring-slate-800">
				<div class="flex items-center justify-between">
					<p class="text-xs font-bold uppercase tracking-wider text-slate-400">Latest Quiz Score</p>
					<span class="rounded-xl bg-emerald-50 p-2 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</span>
				</div>
				<p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
					{{ session('quiz_score') !== null ? session('quiz_score') . '%' : 'N/A' }}
				</p>
				<p class="mt-2.5 text-xs text-slate-400">From your last completed quiz.</p>
			</div>

			<!-- Daily Goal -->
			<div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100 dark:bg-slate-900 dark:ring-slate-800">
				<div class="flex items-center justify-between">
					<p class="text-xs font-bold uppercase tracking-wider text-slate-400">Daily Goal</p>
					<span class="rounded-xl bg-amber-50 p-2 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
						</svg>
					</span>
				</div>
				<p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
					{{ $dailyGoalCompleted }} <span class="text-sm font-medium text-slate-400">/ {{ $dailyGoalTarget }} lessons</span>
				</p>
				<div class="mt-3.5 h-1.5 rounded-full bg-slate-100 dark:bg-slate-800">
					<div class="h-1.5 rounded-full bg-amber-500" style="width: {{ min(100, ($dailyGoalCompleted / $dailyGoalTarget) * 100) }}%"></div>
				</div>
			</div>

			<!-- Learning Streak -->
			<div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100 dark:bg-slate-900 dark:ring-slate-800">
				<div class="flex items-center justify-between">
					<p class="text-xs font-bold uppercase tracking-wider text-slate-400">Learning Streak</p>
					<span class="rounded-xl bg-rose-50 p-2 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400 {{ session('learning_streak', 0) > 0 ? 'animate-bounce' : '' }}">
						<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
						</svg>
					</span>
				</div>
				<p class="mt-3 text-3xl font-extrabold text-slate-800 dark:text-white">
					{{ session('learning_streak', 0) }} <span class="text-sm font-medium text-slate-400">Days</span>
				</p>
				<p class="mt-2.5 text-xs text-slate-400">Keep practicing daily to grow.</p>
			</div>
		</div>

		<!-- Banner Feature -->
		<div class="overflow-hidden rounded-[2rem] border border-slate-900/60 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-6 text-white shadow-xl sm:p-8">
			<div class="grid gap-8 lg:grid-cols-[1.3fr_0.7fr] lg:items-center">
				<div class="space-y-4">
					<div class="inline-flex items-center rounded-full border border-sky-400/20 bg-sky-500/10 px-3 py-0.5 text-[10px] font-bold uppercase tracking-wider text-sky-200">
						Learning snap-shot
					</div>
					<h3 class="text-2xl font-extrabold tracking-tight sm:text-3xl bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent">
						Keep your English journey moving forward.
					</h3>
					<p class="max-w-2xl text-xs leading-6 text-slate-300 sm:text-sm">
						Review completed lessons, return to saved bookmarks, and utilize your dictionary tools to expand vocabulary.
					</p>
				</div>

				<div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
					<div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-300">
						<span>Overall Completion</span>
						<span>{{ $overallProgress }}%</span>
					</div>
					<div class="mt-3 h-2 rounded-full bg-white/10">
						<div class="h-2 rounded-full bg-gradient-to-r from-indigo-400 to-sky-400" style="width: {{ $overallProgress }}%"></div>
					</div>
					<div class="mt-5 grid grid-cols-2 gap-4 text-sm">
						<div class="rounded-xl bg-white/5 border border-white/5 px-4 py-3">
							<div class="text-xs text-slate-400">Lessons Available</div>
							<div class="mt-1 text-xl font-bold text-white">{{ $publishedLessonCount }}</div>
						</div>
						<div class="rounded-xl bg-white/5 border border-white/5 px-4 py-3">
							<div class="text-xs text-slate-400">Completed</div>
							<div class="mt-1 text-xl font-bold text-white">{{ $completedLessons }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Action Banner -->
		<div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dark:bg-slate-900 dark:border-slate-800/80">
			<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
				<div>
					<h3 class="text-lg font-bold text-slate-900 dark:text-white">Start Learning</h3>
					<p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Open the course catalog to explore available modules and study guides.</p>
				</div>
				<a class="btn btn-primary" href="{{ route('student.courses.index') }}">Browse Courses</a>
			</div>
		</div>

		<!-- Bottom Grid: Recent Quiz & Progress Details -->
		<div class="grid gap-6 lg:grid-cols-2">
			<!-- Recent Quiz Card -->
			<div class="rounded-[2rem] border border-slate-100 bg-white p-6.5 shadow-sm dark:bg-slate-900 dark:border-slate-800/80 flex flex-col justify-between">
				<div>
					<h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Quiz Activity</h3>
					<p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Details on your latest completed assessment.</p>
				</div>

				@if ($recentQuiz)
					<div class="mt-6 rounded-2xl bg-slate-50 p-5 dark:bg-slate-800/50">
						<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
							<div class="space-y-1">
								<p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Lesson Module</p>
								<p class="text-base font-bold text-slate-800 dark:text-white">
									{{ $recentQuiz->lesson?->title ?? 'Quiz Completed' }}
								</p>
								<p class="text-xs text-slate-500">
									Completed {{ $recentQuiz->completed_at?->format('F d, Y') }}
								</p>
							</div>

							<div class="rounded-2xl border border-slate-100 bg-white px-5 py-3.5 text-center shadow-sm dark:bg-slate-950 dark:border-slate-800">
								<p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Score</p>
								<p class="mt-1 text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">
									{{ $recentQuiz->score ?? 'N/A' }}%
								</p>
							</div>
						</div>
					</div>
				@else
					<div class="mt-6 rounded-2xl border border-dashed border-slate-200/80 p-6 text-center text-sm text-slate-400 dark:border-slate-800 dark:text-slate-500">
						No quiz results yet. Complete your first lesson quiz to view feedback.
					</div>
				@endif
			</div>

			<!-- Progress Breakdown -->
			<div class="rounded-[2rem] border border-slate-100 bg-white p-6.5 shadow-sm dark:bg-slate-900 dark:border-slate-800/80 space-y-6">
				<h3 class="text-lg font-bold text-slate-900 dark:text-white">Progress Summary</h3>
				
				<div class="space-y-5">
					<div>
						<div class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-slate-400">
							<span>Overall Completion Rate</span>
							<span>{{ $overallProgress }}%</span>
						</div>
						<div class="h-2.5 rounded-full bg-slate-100 dark:bg-slate-800">
							<div class="h-2.5 rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ $overallProgress }}%"></div>
						</div>
					</div>

					<div class="grid gap-4 sm:grid-cols-3">
						<div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-4 dark:bg-slate-800/40 dark:border-slate-800">
							<p class="text-xs font-semibold text-slate-400">Lessons Finished</p>
							<p class="mt-1.5 text-2xl font-bold text-slate-800 dark:text-white">{{ $completedLessons }}</p>
						</div>
						<div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-4 dark:bg-slate-800/40 dark:border-slate-800">
							<p class="text-xs font-semibold text-slate-400">Bookmarks Saved</p>
							<p class="mt-1.5 text-2xl font-bold text-slate-800 dark:text-white">{{ $bookmarkCount }}</p>
						</div>
						<div class="rounded-2xl border border-slate-100 bg-slate-50/60 p-4 dark:bg-slate-800/40 dark:border-slate-800">
							<p class="text-xs font-semibold text-slate-400">Vocabulary learned</p>
							<p class="mt-1.5 text-2xl font-bold text-slate-800 dark:text-white">{{ $vocabularyCount }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
