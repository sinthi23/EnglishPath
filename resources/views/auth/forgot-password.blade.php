<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">Reset your password</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">No worries. Enter your registered email address and we'll send you a password reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Local Development Reset Link Helper -->
    @if (session('dev_reset_link'))
        <div class="mb-5">
            <a href="{{ session('dev_reset_link') }}" class="inline-flex w-full items-center justify-center gap-1.5 px-4 py-3 bg-indigo-600 hover:bg-indigo-550 text-white text-xs font-bold rounded-xl transition shadow-md shadow-indigo-650/15">
                Reset Password Now
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase" />
            <x-text-input id="email" class="mt-1.5 block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-sm text-slate-900 dark:text-white" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white" href="{{ route('login') }}">
                Back to Login
            </a>

            <x-primary-button class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:bg-slate-800">
                Send Link
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
