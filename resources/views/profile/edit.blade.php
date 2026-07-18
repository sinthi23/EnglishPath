<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-extrabold leading-tight text-slate-900 dark:text-white">{{ __('Profile Settings') }}</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Keep your account details accurate and manage your security credentials.</p>
            </div>
            <div class="rounded-full bg-sky-50 dark:bg-sky-950/40 px-4 py-2 text-sm font-bold text-sky-700 dark:text-sky-400">
                Account Overview
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl space-y-6 px-0 sm:px-2 lg:px-0">
            <div class="rounded-[1.75rem] border border-slate-200/70 bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900 p-6 text-white shadow-[0_20px_50px_rgba(15,23,42,0.12)] dark:border-slate-800/80">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-sky-300">Your personal space</p>
                <h3 class="mt-3 text-2xl font-bold leading-snug">Manage your profile, password, and account preferences in one polished place.</h3>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200/70 bg-white p-4 shadow-[0_20px_45px_rgba(15,23,42,0.08)] dark:bg-slate-900 dark:border-slate-800/80 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200/70 bg-white p-4 shadow-[0_20px_45px_rgba(15,23,42,0.08)] dark:bg-slate-900 dark:border-slate-800/80 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200/70 bg-white p-4 shadow-[0_20px_45px_rgba(15,23,42,0.08)] dark:bg-slate-900 dark:border-slate-800/80 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
