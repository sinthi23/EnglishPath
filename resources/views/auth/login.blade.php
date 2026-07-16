<x-guest-layout>
    <div class="mb-6 rounded-[1.25rem] border border-slate-200 dark:border-slate-800/80 bg-gradient-to-br from-slate-50 via-sky-50 to-indigo-50 dark:from-slate-900/60 dark:via-indigo-950/40 dark:to-slate-900/60 p-5 shadow-sm">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">Welcome back</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Log in to continue your personalized English learning experience.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-transparent dark:border-slate-800/40 px-4 py-3">
            <label for="remember_me" class="inline-flex items-center text-sm text-slate-600 dark:text-slate-300">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-sky-600 shadow-sm focus:ring-sky-500" name="remember">
                <span class="ms-2">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-sky-600 hover:text-sky-700" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end pt-2">
            <x-primary-button class="w-full justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:bg-slate-800">
                Login
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
