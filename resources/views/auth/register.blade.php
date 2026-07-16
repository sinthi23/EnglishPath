<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900 dark:text-white">Create your account</h2>
        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Join EnglishPath and begin a cleaner, more focused way to practice English.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-1 block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 px-4 py-3 shadow-sm focus:border-sky-500 focus:ring-sky-500 text-slate-900 dark:text-white"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-white" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:bg-slate-800">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
