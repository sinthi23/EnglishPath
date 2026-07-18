<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    My Saved Bookmarks
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Review and study your saved lessons and vocabulary words.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ activeTab: 'lessons' }">
        <!-- Tabs Nav -->
        <div class="flex border-b border-slate-150 dark:border-slate-800 mb-6">
            <button @click="activeTab = 'lessons'" :class="activeTab === 'lessons' ? 'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700'" class="px-6 py-3 border-b-2 text-sm transition">
                Saved Lessons ({{ $bookmarkedLessons->count() }})
            </button>
            <button @click="activeTab = 'vocabulary'" :class="activeTab === 'vocabulary' ? 'border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700'" class="px-6 py-3 border-b-2 text-sm transition">
                Saved Vocabulary ({{ $bookmarkedVocabs->count() }})
            </button>
        </div>

        <!-- Lessons Tab -->
        <div x-show="activeTab === 'lessons'" class="space-y-6">
            @if ($bookmarkedLessons->isEmpty())
                <div class="rounded-3xl border border-dashed border-slate-200 p-12 text-center text-slate-400 dark:border-slate-800/60 dark:text-slate-500">
                    <p class="text-sm font-semibold">No saved lessons.</p>
                    <p class="mt-1.5 text-xs">Bookmark lessons inside the course catalog to study them later.</p>
                    <a href="{{ route('student.courses.index') }}" class="btn btn-secondary mt-5 text-xs">Browse Courses</a>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($bookmarkedLessons as $lesson)
                        <div class="card relative flex flex-col justify-between group">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="badge badge-{{ strtolower($lesson->level) === 'beginner' ? 'beginner' : (strtolower($lesson->level) === 'intermediate' ? 'intermediate' : 'advanced') }}">
                                        {{ $lesson->level }}
                                    </span>
                                    <form method="POST" action="{{ route('student.bookmarks.lessons.toggle', $lesson) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-rose-500 hover:text-rose-600 dark:hover:text-rose-455 transition" title="Remove Bookmark">
                                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white line-clamp-1 group-hover:text-indigo-650 transition">
                                        {{ $lesson->title }}
                                    </h3>
                                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-2">
                                        {{ strip_tags($lesson->content) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 border-t border-slate-50 dark:border-slate-800/60 pt-4">
                                <a href="{{ route('student.lessons.show', $lesson) }}" class="btn btn-secondary w-full text-xs">
                                    Study Lesson
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Vocabulary Tab -->
        <div x-show="activeTab === 'vocabulary'" class="space-y-6" style="display: none;">
            @if ($bookmarkedVocabs->isEmpty())
                <div class="rounded-3xl border border-dashed border-slate-200 p-12 text-center text-slate-400 dark:border-slate-800/60 dark:text-slate-500">
                    <p class="text-sm font-semibold">No saved vocabulary words.</p>
                    <p class="mt-1.5 text-xs">Use the Dictionary to search and save words for future review.</p>
                    <a href="{{ route('student.dictionary.index') }}" class="btn btn-secondary mt-5 text-xs">Lookup Words</a>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($bookmarkedVocabs as $vocab)
                        <div class="card relative flex flex-col justify-between group">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="badge badge-beginner">
                                        {{ $vocab->difficulty }}
                                    </span>
                                    <form method="POST" action="{{ route('student.bookmarks.vocabularies.toggle', $vocab) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-rose-500 hover:text-rose-600 dark:hover:text-rose-455 transition" title="Remove Bookmark">
                                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white capitalize group-hover:text-indigo-650 transition">
                                        {{ $vocab->word }}
                                    </h3>
                                    <p class="mt-2 text-xs font-semibold text-slate-600 dark:text-slate-350">
                                        {{ $vocab->meaning }}
                                    </p>
                                    @if($vocab->example)
                                        <p class="mt-2.5 text-xs italic text-slate-500 dark:text-slate-400 pl-2.5 border-l-2 border-slate-100 dark:border-slate-800/80">
                                            "{{ $vocab->example }}"
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
