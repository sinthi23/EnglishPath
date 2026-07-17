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
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 pr-12 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <!-- Eye Icon -->
                    <svg class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Eye Off Icon -->
                    <svg class="h-5 w-5 eye-off-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <script>
            function togglePasswordVisibility(inputId, btn) {
                const input = document.getElementById(inputId);
                const eyeIcon = btn.querySelector('.eye-icon');
                const eyeOffIcon = btn.querySelector('.eye-off-icon');
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                }
            }
        </script>

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
