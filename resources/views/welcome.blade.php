<x-guest-layout>
    <div class="space-y-6">
        <div class="rounded-[1.75rem] border border-slate-100 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-6.5 text-white shadow-[0_20px_50px_rgba(15,23,42,0.18)]">
            <div class="inline-flex items-center rounded-full border border-sky-400/20 bg-sky-500/10 px-3.5 py-1 text-[10px] font-bold uppercase tracking-[0.25em] text-sky-200">
                EnglishPath • Lab Project
            </div>
            <h2 class="mt-5 text-2xl font-extrabold leading-tight tracking-tight sm:text-3xl bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent">A polished English learning experience.</h2>
            <p class="mt-4.5 text-xs leading-6 text-slate-300 sm:text-sm">
                Built with a clean interface, interactive vocabulary tools, custom difficulty options, and an elegant student dashboard designed to stand out.
            </p>
        </div>

        <div class="grid gap-3.5 rounded-[1.75rem] border border-slate-200/60 bg-white/70 p-4 shadow-sm backdrop-blur-md sm:grid-cols-3">
            <div class="group rounded-2xl bg-slate-50/70 p-4 text-center transition duration-200 hover:bg-white hover:shadow-md hover:ring-1 hover:ring-slate-100">
                <div class="text-3xl transition duration-300 group-hover:scale-110">📚</div>
                <p class="mt-2.5 text-xs font-bold uppercase tracking-wider text-slate-500">Lessons</p>
            </div>
            <div class="group rounded-2xl bg-slate-50/70 p-4 text-center transition duration-200 hover:bg-white hover:shadow-md hover:ring-1 hover:ring-slate-100">
                <div class="text-3xl transition duration-300 group-hover:scale-110">🧠</div>
                <p class="mt-2.5 text-xs font-bold uppercase tracking-wider text-slate-500">Vocabulary</p>
            </div>
            <div class="group rounded-2xl bg-slate-50/70 p-4 text-center transition duration-200 hover:bg-white hover:shadow-md hover:ring-1 hover:ring-slate-100">
                <div class="text-3xl transition duration-300 group-hover:scale-110">↗</div>
                <p class="mt-2.5 text-xs font-bold uppercase tracking-wider text-slate-500">Progress</p>
            </div>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('login') }}" class="flex-1 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-slate-900/10 transition duration-200 hover:bg-indigo-650 hover:shadow-indigo-650/10 active:scale-[0.98]">
                Login to dashboard
            </a>
            <a href="{{ route('register') }}" class="flex-1 inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-bold text-slate-700 transition duration-200 hover:bg-slate-50 active:scale-[0.98]">
                Create account
            </a>
        </div>
    </div>
</x-guest-layout>
