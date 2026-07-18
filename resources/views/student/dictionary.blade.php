<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Dictionary Lookup
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Search any English word to see its phonetic transcript, meanings, synonyms, and examples.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl space-y-6">
            <!-- Search bar card -->
            <div class="rounded-[2.25rem] border border-slate-100 bg-white p-6 shadow-sm dark:bg-slate-900 dark:border-slate-800/60">
                <form id="dictForm" class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none text-slate-400">
                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" id="wordInput" placeholder="Type a word (e.g. 'resilience', 'ephemeral')..."
                            class="pl-12 w-full rounded-2xl border-slate-200 dark:bg-slate-800 dark:text-white focus:border-sky-500 focus:ring-4 focus:ring-sky-100">
                    </div>
                    <button type="submit"
                        class="btn btn-primary px-8.5 py-3">
                        Lookup
                    </button>
                </form>
            </div>

            <!-- Result block -->
            <div id="result" class="card hidden"></div>
        </div>
    </div>

    <script>
        const dictForm = document.getElementById('dictForm');
        const resultBox = document.getElementById('result');
        const lookupUrlBase = "{{ url('/student/dictionary/lookup') }}";

        dictForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const word = document.getElementById('wordInput').value.trim();
            resultBox.classList.remove('hidden');

            if (!word) {
                resultBox.innerHTML = '<p class="text-slate-500 text-sm text-center py-4">Please enter a word to search.</p>';
                return;
            }

            resultBox.innerHTML = `
                <div class="flex items-center justify-center gap-2 py-8">
                    <svg class="animate-spin h-5 w-5 text-indigo-650" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-slate-500">Searching English dictionary...</span>
                </div>`;

            try {
                const response = await fetch(`${lookupUrlBase}/${encodeURIComponent(word)}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Word not found.');

                let html = `
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-5 dark:border-slate-800">
                        <div>
                            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white capitalize">${data.word}</h3>
                            ${data.phonetic ? '<p class="text-sm font-semibold text-slate-400 mt-1">/' + data.phonetic + '/</p>' : ''}
                        </div>
                        <button type="button" id="saveWordBtn" class="btn btn-secondary px-5 py-2 text-xs flex items-center gap-1.5" onclick="saveToVocabulary('${data.word}', '${data.meanings[0]?.definition || ''}', '${data.meanings[0]?.example || ''}', '${data.synonyms?.join(', ') || ''}')">
                            <svg class="h-4.5 w-4.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            Save Word
                        </button>
                    </div>
                `;

                html += '<div class="space-y-6 mt-6">';
                data.meanings.forEach(m => {
                    html += `
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="badge bg-indigo-50 text-indigo-700 dark:bg-indigo-950/30 dark:text-indigo-400">${m.partOfSpeech}</span>
                            </div>
                            <p class="text-sm leading-7 text-slate-700 dark:text-slate-300 font-medium">${m.definition ?? ''}</p>
                            ${m.example ? `
                                <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-4.5 dark:bg-slate-800/20 dark:border-slate-800">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Example Usage</p>
                                    <p class="text-xs italic text-slate-600 dark:text-slate-400 leading-relaxed">"${m.example}"</p>
                                </div>
                            ` : ''}
                        </div>
                    `;
                });
                html += '</div>';

                if (data.synonyms && data.synonyms.length) {
                    html += `
                        <div class="mt-8 border-t border-slate-100 pt-5 dark:border-slate-800">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Synonyms</p>
                            <div class="flex flex-wrap gap-1.5">
                                ${data.synonyms.map(syn => `
                                    <span class="rounded-lg bg-slate-50 border border-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800/40 dark:border-slate-800 dark:text-slate-300 capitalize">${syn}</span>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                resultBox.innerHTML = html;

            } catch (error) {
                resultBox.innerHTML = `
                    <div class="text-center py-6">
                        <p class="text-red-500 text-sm font-semibold">${error.message}</p>
                        <p class="text-xs text-slate-400 mt-1">Please verify the word spelling and try again.</p>
                    </div>`;
            }
        });

        async function saveToVocabulary(word, meaning, example, synonym) {
            const btn = document.getElementById('saveWordBtn');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Saving...';
            
            try {
                const response = await fetch("{{ route('student.dictionary.save') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ word, meaning, example, synonym })
                });
                
                const data = await response.json();
                if (response.ok) {
                    btn.innerHTML = `
                        <svg class="h-4.5 w-4.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                        </svg>
                        Saved
                    `;
                    alert(data.message);
                } else {
                    throw new Error(data.message || 'Failed to save word.');
                }
            } catch (error) {
                alert(error.message);
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        }
    </script>
</x-app-layout>
