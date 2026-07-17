<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 pr-12 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
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
            
            <!-- Password Criteria Checklist -->
            <div id="password-criteria" class="mt-3 hidden space-y-1.5 rounded-2xl border border-slate-100 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-900/40 p-3.5 text-xs text-slate-500 dark:text-slate-400">
                <p class="font-semibold text-slate-700 dark:text-slate-300 mb-1">Password requirements:</p>
                <div id="crit-length" class="flex items-center gap-2 transition duration-200">
                    <span class="status-icon text-slate-300 dark:text-slate-600">○</span>
                    <span>8+ characters</span>
                </div>
                <div id="crit-upper" class="flex items-center gap-2 transition duration-200">
                    <span class="status-icon text-slate-300 dark:text-slate-600">○</span>
                    <span>At least one uppercase letter (A-Z)</span>
                </div>
                <div id="crit-number" class="flex items-center gap-2 transition duration-200">
                    <span class="status-icon text-slate-300 dark:text-slate-600">○</span>
                    <span>At least one number (0-9)</span>
                </div>
                <div id="crit-special" class="flex items-center gap-2 transition duration-200">
                    <span class="status-icon text-slate-300 dark:text-slate-600">○</span>
                    <span>At least one special character (@$!%*?&)</span>
                </div>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative mt-1">
                <x-text-input id="password_confirmation" class="block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 pr-12 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
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
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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

            document.addEventListener('DOMContentLoaded', () => {
                const passwordInput = document.getElementById('password');
                const criteriaContainer = document.getElementById('password-criteria');

                const requirements = {
                    length: { regex: /.{8,}/, el: document.getElementById('crit-length') },
                    upper: { regex: /[A-Z]/, el: document.getElementById('crit-upper') },
                    number: { regex: /[0-9]/, el: document.getElementById('crit-number') },
                    special: { regex: /[@$!%*?&]/, el: document.getElementById('crit-special') }
                };

                passwordInput.addEventListener('focus', () => {
                    criteriaContainer.classList.remove('hidden');
                });

                passwordInput.addEventListener('input', () => {
                    const val = passwordInput.value;
                    validateRule(requirements.length, val);
                    validateRule(requirements.upper, val);
                    validateRule(requirements.number, val);
                    validateRule(requirements.special, val);
                });

                function validateRule(rule, val) {
                    const isMatched = rule.regex.test(val);
                    const icon = rule.el.querySelector('.status-icon');
                    if (isMatched) {
                        rule.el.classList.remove('text-slate-500', 'dark:text-slate-400');
                        rule.el.classList.add('text-emerald-600', 'dark:text-emerald-400', 'font-semibold');
                        icon.innerHTML = '✓';
                        icon.classList.remove('text-slate-300', 'dark:text-slate-600');
                        icon.classList.add('text-emerald-500');
                    } else {
                        rule.el.classList.remove('text-emerald-600', 'dark:text-emerald-400', 'font-semibold');
                        rule.el.classList.add('text-slate-500', 'dark:text-slate-400');
                        icon.innerHTML = '○';
                        icon.classList.remove('text-emerald-500');
                        icon.classList.add('text-slate-300', 'dark:text-slate-600');
                    }
                }
            });
        </script>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
