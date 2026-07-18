<x-app-layout>
	<x-slot name="header">
		<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
			<div>
				<div class="flex items-center gap-2">
					<a href="{{ $lesson->course_id ? route('student.courses.show', $lesson->course_id) : route('student.courses.index') }}" class="text-xs font-bold text-indigo-600 hover:underline dark:text-indigo-400">Course Syllabus</a>
					<span class="text-xs text-slate-400">/</span>
					<span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Module View</span>
				</div>
				<h2 class="mt-1.5 text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">{{ $lesson->title }}</h2>
			</div>
			<div class="inline-flex items-center gap-2 rounded-full bg-slate-50 border border-slate-200/80 px-4 py-2 text-xs font-bold text-slate-700 dark:bg-slate-900 dark:border-slate-800 dark:text-slate-300">
				Level: <span class="badge badge-{{ strtolower($lesson->level) === 'beginner' ? 'beginner' : (strtolower($lesson->level) === 'intermediate' ? 'intermediate' : 'advanced') }} ml-1.5">{{ $lesson->level }}</span>
			</div>
		</div>
	</x-slot>

	<div class="py-6">
		<div class="mx-auto max-w-5xl space-y-8">
			<!-- Video Lesson Section -->
			@if ($lesson->video_url)
				@php
					$youtubeId = null;
					if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|watch\?v=)|youtu\.be/)([^"&?/ ]{11})%i', $lesson->video_url, $match)) {
						$youtubeId = $match[1];
					}
				@endphp
				<div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-slate-950 shadow-md dark:border-slate-800">
					@if ($youtubeId)
						<div class="aspect-video w-full">
							<iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					@else
						<div class="p-8 text-center text-slate-400">
							<p class="text-sm font-semibold mb-2">Interactive Video Stream</p>
							<a href="{{ $lesson->video_url }}" target="_blank" class="inline-flex items-center gap-1 text-sky-500 hover:underline">
								<span>Watch External Video</span>
								<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 00-2 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
								</svg>
							</a>
						</div>
					@endif
				</div>
			@endif

			<!-- Main Lesson Content -->
			<div class="rounded-[2.25rem] border border-slate-100 bg-white p-6 sm:p-10 shadow-sm dark:bg-slate-900 dark:border-slate-800/60">
				<div class="flex items-center gap-2">
					<span class="badge badge-{{ strtolower($lesson->level) === 'beginner' ? 'beginner' : (strtolower($lesson->level) === 'intermediate' ? 'intermediate' : 'advanced') }}">
						{{ $lesson->level }}
					</span>
					<span class="text-xs font-semibold text-slate-400">Difficulty: <span class="capitalize text-slate-600 dark:text-slate-300">{{ $lesson->difficulty }}</span></span>
				</div>
				
				<h3 class="mt-4 text-3xl font-extrabold text-slate-950 dark:text-white tracking-tight">{{ $lesson->title }}</h3>
				
				<div class="mt-8 text-sm leading-8 text-slate-700 dark:text-slate-300 whitespace-pre-line prose max-w-none dark:prose-invert">
					{!! nl2br(e($lesson->content)) !!}
				</div>
			</div>

			<!-- Status Info Grid -->
			<div class="grid gap-6 sm:grid-cols-2">
				<div class="rounded-3xl border border-slate-100 bg-slate-50/50 p-6 dark:bg-slate-800/20 dark:border-slate-800">
					<p class="text-xs font-bold uppercase tracking-wider text-slate-400">Latest Quiz Score</p>
					<p class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
						{{ session('quiz_score') !== null ? session('quiz_score') . '%' : 'N/A' }}
					</p>
				</div>
				<div class="rounded-3xl border border-slate-100 bg-slate-50/50 p-6 dark:bg-slate-800/20 dark:border-slate-800">
					<p class="text-xs font-bold uppercase tracking-wider text-slate-400">Last Visited Date</p>
					<p class="mt-2 text-2xl font-extrabold text-slate-800 dark:text-white">
						{{ $latestProgress?->completed_at?->format('M d, Y') ?? 'Not completed yet' }}
					</p>
				</div>
			</div>

			<!-- Linked Quiz Callout -->
			@if ($lesson->quiz)
				<div class="rounded-[2rem] border border-slate-100 bg-white p-6.5 dark:bg-slate-900 dark:border-slate-800/60 shadow-sm flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
					<div>
						<h3 class="text-lg font-bold text-slate-900 dark:text-white">Lesson Assessment</h3>
						<p class="text-xs text-slate-550 dark:text-slate-400 mt-1">Take the associated lesson quiz to evaluate your grammar and vocabulary recall.</p>
					</div>
					<a href="{{ route('student.quizzes.show', $lesson->quiz) }}" class="btn btn-primary">
						Start Lesson Quiz
					</a>
				</div>
			@endif

			<!-- Navigation actions -->
			<div class="flex items-center justify-between pt-4">
				<a class="btn btn-secondary" href="{{ $lesson->course_id ? route('student.courses.show', $lesson->course_id) : route('student.courses.index') }}">
					<svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
					</svg>
					{{ $lesson->course_id ? 'Back to Course' : 'Back to Catalog' }}
				</a>
				<div class="flex items-center gap-2.5">
					@php
						$isBookmarked = \App\Models\Bookmark::where('user_id', auth()->id())
							->where('lesson_id', $lesson->id)
							->exists();
					@endphp
					<form method="POST" action="{{ route('student.bookmarks.lessons.toggle', $lesson) }}" class="inline">
						@csrf
						<button type="submit" class="btn {{ $isBookmarked ? 'bg-rose-50 border-rose-200 text-rose-700 hover:bg-rose-100 dark:bg-rose-950/20 dark:border-rose-900/40 dark:text-rose-450 border' : 'btn-secondary' }}">
							<svg class="mr-2 h-4 w-4 {{ $isBookmarked ? 'fill-current' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
							</svg>
							{{ $isBookmarked ? 'Bookmarked' : 'Bookmark' }}
						</button>
					</form>
					<a class="btn btn-primary" href="{{ route('student.dashboard') }}">
						Go to Dashboard
					</a>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
