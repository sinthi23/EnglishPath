@extends('admin.layout')

@section('title', 'Edit Listening Exercise')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Edit Listening Exercise</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Modify settings, replace audio source, or manage questions.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.listening-materials.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form method="POST" action="{{ route('admin.listening-materials.update', $listeningMaterial) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="title">Exercise Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $listeningMaterial->title) }}" placeholder="e.g. Intermediate Listening: Travel Vocabulary" required autofocus>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="difficulty">Relative Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <option value="beginner" @selected(old('difficulty', $listeningMaterial->difficulty) === 'beginner')>Beginner</option>
                        <option value="intermediate" @selected(old('difficulty', $listeningMaterial->difficulty) === 'intermediate')>Intermediate</option>
                        <option value="advanced" @selected(old('difficulty', $listeningMaterial->difficulty) === 'advanced')>Advanced</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-slate-50 dark:border-slate-800/60 pt-4 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Audio Source Configuration</h4>
                
                <div class="rounded-xl bg-slate-50/50 p-4 border border-slate-100 dark:bg-slate-900/50 dark:border-slate-800/80 flex items-center gap-3">
                    <svg class="h-6 w-6 text-indigo-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>
                    <div class="truncate">
                        <p class="text-xs font-bold text-slate-900 dark:text-white">Active Audio Link</p>
                        <a href="{{ $listeningMaterial->audio_url }}" target="_blank" class="text-xs text-sky-600 hover:underline truncate block max-w-xl">{{ $listeningMaterial->audio_url }}</a>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="audio_file">Replace Audio File (MP3/WAV/M4A)</label>
                        <input type="file" id="audio_file" name="audio_file" accept="audio/*">
                    </div>
                    
                    <div class="flex flex-col justify-end">
                        <label for="audio_url">Replace Remote Audio URL</label>
                        <input type="url" id="audio_url" name="audio_url" value="{{ old('audio_url', $listeningMaterial->audio_url) }}" placeholder="e.g. https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.listening-materials.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Update Exercise</button>
            </div>
        </form>
    </div>

    <!-- Questions Manager -->
    <div class="card space-y-6">
        <div class="border-b border-slate-50 dark:border-slate-800/60 pb-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Manage Listening Questions</h3>
            <p class="text-xs text-slate-500 font-medium">Add, review, and delete multiple-choice comprehension questions for this audio clip.</p>
        </div>

        <!-- AJAX Alert Banner -->
        <div id="ajax-alert" class="hidden w-fit items-center gap-2.5 rounded-2xl border px-4 py-2.5 text-xs font-semibold"></div>

        <!-- Add Question Form -->
        <form id="add-question-form" method="POST" action="{{ route('admin.listening-materials.questions.store', $listeningMaterial) }}" class="space-y-4 bg-slate-50/30 dark:bg-slate-950/40 p-5 rounded-2xl border border-slate-100 dark:border-slate-800/80">
            @csrf
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Add New Question</h4>
            
            <div>
                <label for="question">Question Text</label>
                <input type="text" id="question" name="question" placeholder="e.g. What main topic did the speaker discuss in the beginning?" required>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="option_a">Option A</label>
                    <input type="text" id="option_a" name="option_a" required>
                </div>
                <div>
                    <label for="option_b">Option B</label>
                    <input type="text" id="option_b" name="option_b" required>
                </div>
                <div>
                    <label for="option_c">Option C</label>
                    <input type="text" id="option_c" name="option_c" required>
                </div>
                <div>
                    <label for="option_d">Option D</label>
                    <input type="text" id="option_d" name="option_d" required>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="correct_answer">Correct Option</label>
                    <select id="correct_answer" name="correct_answer">
                        <option value="A">Option A</option>
                        <option value="B">Option B</option>
                        <option value="C">Option C</option>
                        <option value="D">Option D</option>
                    </select>
                </div>
                <div class="flex items-end justify-end">
                    <button id="add-question-btn" class="btn btn-primary px-5 py-2.5 text-xs bg-emerald-600 hover:bg-emerald-500 border-none" type="submit">Add Question</button>
                </div>
            </div>
        </form>

        <!-- Current Questions List -->
        <div id="questions-section" class="space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Existing Questions (<span id="questions-count">{{ $listeningMaterial->questions->count() }}</span>)</h4>
            
            <p id="no-questions-placeholder" class="text-xs text-slate-400 italic {{ $listeningMaterial->questions->isEmpty() ? '' : 'hidden' }}">No questions added to this listening exercise yet.</p>
            
            <div id="questions-table-wrapper" class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-slate-800 {{ $listeningMaterial->questions->isEmpty() ? 'hidden' : '' }}">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 font-bold border-b border-slate-100 dark:border-slate-800">
                            <th class="p-4">#</th>
                            <th class="p-4">Question</th>
                            <th class="p-4">Options</th>
                            <th class="p-4 text-center">Correct</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="questions-tbody" class="divide-y divide-slate-50 dark:divide-slate-800/60 font-medium">
                        @foreach ($listeningMaterial->questions as $index => $q)
                            <tr id="question-row-{{ $q->id }}" class="hover:bg-slate-50/30 dark:hover:bg-slate-800/25">
                                <td class="p-4 font-bold text-slate-400 question-index">{{ $index + 1 }}</td>
                                <td class="p-4 text-slate-900 dark:text-white max-w-xs truncate">{{ $q->question }}</td>
                                <td class="p-4 text-slate-500">
                                    A: {{ $q->option_a }} | B: {{ $q->option_b }} | C: {{ $q->option_c }} | D: {{ $q->option_d }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="badge badge-beginner">{{ $q->correct_answer }}</span>
                                </td>
                                <td class="p-4 text-right">
                                    <form method="POST" action="{{ route('admin.listening-materials.questions.destroy', [$listeningMaterial, $q]) }}" class="delete-question-form inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-600 hover:underline text-[11px] font-bold">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- AJAX Async Operations Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addForm = document.getElementById('add-question-form');
            const alertBox = document.getElementById('ajax-alert');
            const questionsTbody = document.getElementById('questions-tbody');
            const placeholder = document.getElementById('no-questions-placeholder');
            const tableWrapper = document.getElementById('questions-table-wrapper');
            const countBadge = document.getElementById('questions-count');
            const addBtn = document.getElementById('add-question-btn');
            
            const materialId = "{{ $listeningMaterial->id }}";
            const csrfToken = "{{ csrf_token() }}";

            // Helper to escape HTML to prevent XSS
            function escapeHtml(str) {
                return str
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Helper to show alert status
            function showAlert(message, isSuccess = true) {
                alertBox.classList.remove('hidden', 'flex', 'bg-emerald-500/5', 'border-emerald-500/10', 'text-emerald-800', 'dark:text-emerald-400', 'bg-rose-500/5', 'border-rose-500/10', 'text-rose-800', 'dark:text-rose-450');
                alertBox.innerHTML = '';
                
                const icon = isSuccess 
                    ? `<svg class="h-4 w-4 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`
                    : `<svg class="h-4 w-4 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
                
                alertBox.innerHTML = `${icon} <span>${message}</span>`;
                alertBox.classList.add('flex');
                
                if (isSuccess) {
                    alertBox.classList.add('bg-emerald-500/5', 'border-emerald-500/10', 'text-emerald-800', 'dark:text-emerald-400');
                    setTimeout(() => {
                        alertBox.classList.add('hidden');
                        alertBox.classList.remove('flex');
                    }, 4000);
                } else {
                    alertBox.classList.add('bg-rose-500/5', 'border-rose-500/10', 'text-rose-800', 'dark:text-rose-450');
                }
            }

            // Recalculate row indices
            function reindexQuestions() {
                const rows = document.querySelectorAll('#questions-tbody tr');
                rows.forEach((row, idx) => {
                    const idxCell = row.querySelector('.question-index');
                    if (idxCell) {
                        idxCell.textContent = idx + 1;
                    }
                });
                countBadge.textContent = rows.length;

                if (rows.length === 0) {
                    placeholder.classList.remove('hidden');
                    tableWrapper.classList.add('hidden');
                } else {
                    placeholder.classList.add('hidden');
                    tableWrapper.classList.remove('hidden');
                }
            }

            // Add Question AJAX Submission
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                addBtn.disabled = true;
                const originalText = addBtn.textContent;
                addBtn.textContent = 'Adding...';

                const formData = new FormData(addForm);
                try {
                    const response = await fetch(addForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        // Clear form text inputs
                        document.getElementById('question').value = '';
                        document.getElementById('option_a').value = '';
                        document.getElementById('option_b').value = '';
                        document.getElementById('option_c').value = '';
                        document.getElementById('option_d').value = '';
                        document.getElementById('correct_answer').value = 'A';

                        // Append row to table
                        const newRowId = `question-row-${data.question.id}`;
                        const deleteRoute = `/admin/listening-materials/${materialId}/questions/${data.question.id}`;
                        const trHtml = `
                            <tr id="${newRowId}" class="hover:bg-slate-50/30 dark:hover:bg-slate-800/25">
                                <td class="p-4 font-bold text-slate-400 question-index">1</td>
                                <td class="p-4 text-slate-900 dark:text-white max-w-xs truncate">${escapeHtml(data.question.question)}</td>
                                <td class="p-4 text-slate-500">
                                    A: ${escapeHtml(data.question.option_a)} | B: ${escapeHtml(data.question.option_b)} | C: ${escapeHtml(data.question.option_c)} | D: ${escapeHtml(data.question.option_d)}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="badge badge-beginner">${escapeHtml(data.question.correct_answer)}</span>
                                </td>
                                <td class="p-4 text-right">
                                    <form method="POST" action="${deleteRoute}" class="delete-question-form inline">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-rose-500 hover:text-rose-600 hover:underline text-[11px] font-bold">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `;
                        
                        questionsTbody.insertAdjacentHTML('beforeend', trHtml);
                        reindexQuestions();
                        showAlert(data.message || 'Question added!', true);
                    } else {
                        const errorMsg = data.message || 'Validation error. Please verify the question inputs.';
                        showAlert(errorMsg, false);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Server error. Failed to add question.', false);
                } finally {
                    addBtn.disabled = false;
                    addBtn.textContent = originalText;
                }
            });

            // Delete Question AJAX Submission (via delegation)
            questionsTbody.addEventListener('submit', async (e) => {
                const targetForm = e.target;
                if (!targetForm.classList.contains('delete-question-form')) return;
                
                e.preventDefault();
                if (!confirm('Delete this question?')) return;

                const tr = targetForm.closest('tr');
                const submitBtn = targetForm.querySelector('button');
                submitBtn.disabled = true;
                
                try {
                    const response = await fetch(targetForm.action, {
                        method: 'POST',
                        body: new FormData(targetForm),
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        tr.remove();
                        reindexQuestions();
                        showAlert(data.message || 'Question deleted!', true);
                    } else {
                        showAlert(data.message || 'Failed to delete question.', false);
                        submitBtn.disabled = false;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('Server error. Failed to delete question.', false);
                    submitBtn.disabled = false;
                }
            });
        });
    </script>
</div>
@endsection
