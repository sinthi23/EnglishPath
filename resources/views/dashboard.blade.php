<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Your saved cookie preferences are applied here.') }}
                </p>
            </div>
            <div class="rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                {{ __('Theme') }}: {{ ucfirst($themePreference ?? 'light') }} | {{ __('Language') }}: {{ strtoupper($languagePreference ?? 'en') }} | {{ __('Layout') }}: {{ ucfirst($dashboardLayoutPreference ?? 'comfortable') }}
            </div>
        </div>
    </x-slot>

    @php
        $dashboardSummaryGridClass = ($dashboardLayoutPreference ?? 'comfortable') === 'compact'
            ? 'grid gap-4 md:grid-cols-2 xl:grid-cols-3'
            : 'grid gap-6 md:grid-cols-2 xl:grid-cols-4';
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">{{ __('Preferences') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Use cookies for theme, preferred language, and dashboard layout. No passwords are stored.') }}
                            </p>
                        </div>
                        <div class="rounded-2xl bg-gray-50 px-4 py-3 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300">
                            {{ __('Saved values are remembered for 30 days.') }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('preferences.update') }}" class="mt-6 grid gap-4 lg:grid-cols-3">
                        @csrf

                        <div>
                            <label for="theme" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Theme') }}</label>
                            <select id="theme" name="theme" class="block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="light" @selected(old('theme', $themePreference ?? 'light') === 'light')>{{ __('Light') }}</option>
                                <option value="dark" @selected(old('theme', $themePreference ?? 'light') === 'dark')>{{ __('Dark') }}</option>
                            </select>
                            @error('theme')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="preferred_language" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Preferred Language') }}</label>
                            <select id="preferred_language" name="preferred_language" class="block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="en" @selected(old('preferred_language', $languagePreference ?? 'en') === 'en')>{{ __('English') }}</option>
                                <option value="bn" @selected(old('preferred_language', $languagePreference ?? 'en') === 'bn')>{{ __('Bangla') }}</option>
                            </select>
                            @error('preferred_language')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dashboard_layout" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Dashboard Layout') }}</label>
                            <select id="dashboard_layout" name="dashboard_layout" class="block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                                <option value="comfortable" @selected(old('dashboard_layout', $dashboardLayoutPreference ?? 'comfortable') === 'comfortable')>{{ __('Comfortable') }}</option>
                                <option value="compact" @selected(old('dashboard_layout', $dashboardLayoutPreference ?? 'comfortable') === 'compact')>{{ __('Compact') }}</option>
                            </select>
                            @error('dashboard_layout')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="lg:col-span-3 flex flex-wrap gap-3 pt-2">
                            <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                {{ __('Save Preferences') }}
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('preferences.destroy') }}" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800">
                            {{ __('Clear Preferences') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="{{ $dashboardSummaryGridClass }}">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Theme') }}</p>
                    <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ ucfirst($themePreference ?? 'light') }}</p>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Language') }}</p>
                    <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ strtoupper($languagePreference ?? 'en') }}</p>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Layout') }}</p>
                    <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ ucfirst($dashboardLayoutPreference ?? 'comfortable') }}</p>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Session safety') }}</p>
                    <p class="mt-3 text-sm leading-6 text-slate-700 dark:text-slate-300">
                        {{ __('Cookies store only display preferences. Passwords stay in the authentication system, not in cookies.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
