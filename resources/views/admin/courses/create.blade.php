@extends('admin.layout')

@section('title', 'Create Course')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">
    <!-- Header with Back action -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-950 dark:text-white">Create New Course</h2>
            <p class="mt-1 text-xs text-slate-500 font-medium">Add a new proficiency curriculum stage to the platform.</p>
        </div>
        <a class="btn btn-secondary px-4 py-2 text-xs" href="{{ route('admin.courses.index') }}">
            Back to Catalog
        </a>
    </div>

    <!-- Form Panel -->
    <div class="card">
        <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-5">
            @csrf
            
            <div>
                <label for="title">Course Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. GRE Verbal Reasoning Path" required autofocus>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Briefly describe the syllabus, prerequisites, and learning outcome...">{{ old('description') }}</textarea>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <label for="level">Target Level</label>
                    <select id="level" name="level">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                
                <div>
                    <label for="price">Price (BDT)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', 0) }}" min="0" placeholder="e.g. 49" required>
                </div>
                
                <div class="flex items-center pt-8">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="h-4.5 w-4.5" checked>
                        <span class="ml-2.5 text-sm font-semibold text-slate-700 dark:text-slate-300">Publish Immediately</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50 dark:border-slate-850 flex items-center justify-end gap-2.5">
                <a class="btn btn-secondary" href="{{ route('admin.courses.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save Course</button>
            </div>
        </form>
    </div>
</div>
@endsection
