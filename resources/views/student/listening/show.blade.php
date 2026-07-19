<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    {{ $listeningMaterial->title }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Difficulty: <span class="capitalize font-bold">{{ $listeningMaterial->difficulty }}</span> | Please play the audio clip before answering the questions.
                </p>
            </div>
            <a class="btn btn-secondary text-xs px-4 py-2" href="{{ route('student.listening.index') }}">
                Back to Catalog
            </a>
        </div>
    </x-slot>

    @php
        $isYoutube = false;
        $youtubeEmbedUrl = '';
        $audioUrl = $listeningMaterial->audio_url;

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $audioUrl, $match)) {
            $isYoutube = true;
            $youtubeEmbedUrl = "https://www.youtube.com/embed/" . $match[1];
        }
    @endphp

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-6">
            
            <!-- Audio/Video Clip Player Card -->
            <div class="card bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-950 border-slate-850 p-6 flex flex-col items-center gap-6 shadow-xl">
                <div class="space-y-1.5 text-center text-white">
                    <span class="badge bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        {{ $isYoutube ? 'Video & Audio Clip' : 'Audio Clip' }}
                    </span>
                    <h3 class="text-base font-bold">Listen Carefully</h3>
                    <p class="text-xs text-slate-450 dark:text-slate-400 font-medium">
                        {{ $isYoutube ? 'Play the video below to listen to the audio track.' : 'You can pause, scrub, or replay the track as needed.' }}
                    </p>
                </div>
                
                @if ($isYoutube)
                    <div class="w-full max-w-2xl aspect-video rounded-2xl overflow-hidden shadow-2xl border border-indigo-500/20">
                        <iframe class="w-full h-full" src="{{ $youtubeEmbedUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                @else
                    <div class="w-full md:w-96 flex items-center justify-center">
                        <audio controls class="w-full rounded-full bg-slate-900 border border-slate-800">
                            <source src="{{ $audioUrl }}" type="audio/mpeg">
                            <source src="{{ $audioUrl }}" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                @endif
            </div>

            <!-- Questions Form Card -->
            <div class="card">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Comprehension Questions</h3>
                    <p class="mt-1 text-xs text-slate-500">Read each query and choose the best matching option based on the audio recording.</p>
                </div>

                @if ($listeningMaterial->questions->isEmpty())
                    <p class="text-xs text-slate-400 italic text-center py-6">No questions have been linked to this exercise yet.</p>
                @else
                    <form method="POST" action="{{ route('student.listening.submit', $listeningMaterial) }}" class="space-y-8">
                        @csrf
                        
                        @foreach ($listeningMaterial->questions as $index => $question)
                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white flex items-start gap-2.5">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-xs font-extrabold text-indigo-650 dark:text-indigo-400">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="leading-6">{{ $question->question }}</span>
                                </h4>

                                <div class="grid gap-3.5 sm:grid-cols-2 pl-8.5">
                                    @foreach (['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d'] as $key => $optionField)
                                        <label class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50/50 p-4 text-xs font-semibold text-slate-700 dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-200 cursor-pointer hover:bg-slate-100/50 dark:hover:bg-slate-800/60 transition normal-case tracking-normal mb-0">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="h-4.5 w-4.5 border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-900 dark:border-slate-800" required>
                                            <span>{{ $question->$optionField }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-6 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end">
                            <button type="submit" class="btn btn-primary bg-indigo-650 hover:bg-indigo-550 border-none">
                                Submit Listening Answers
                            </button>
                        </div>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
