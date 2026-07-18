<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Secure Checkout
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Complete your payment to unlock full access to the course material.
                </p>
            </div>
            <a class="btn btn-secondary text-xs px-4 py-2" href="{{ route('student.courses.show', $course) }}">
                Back to Course
            </a>
        </div>
    </x-slot>

    <div class="py-6" x-data="{ paymentMethod: 'card' }">
        <div class="mx-auto max-w-4xl grid gap-8 md:grid-cols-[0.8fr_1.2fr]">
            
            <!-- Left Column: Course & Price Summary -->
            <div class="space-y-6">
                <div class="card p-6 border-indigo-100/50 dark:border-indigo-950/60 bg-slate-50/50 dark:bg-slate-900/60">
                    <span class="badge bg-indigo-50 text-indigo-700 dark:bg-indigo-950/40 dark:text-indigo-400 font-bold mb-3">Selected Course</span>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug">{{ $course->title }}</h3>
                    <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">{{ $course->description }}</p>
                    
                    <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800/80 space-y-4">
                        <div class="flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-850 dark:text-slate-200">৳{{ number_format($course->price) }} BDT</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                            <span>Processing Fee</span>
                            <span class="text-emerald-500 dark:text-emerald-400 font-extrabold tracking-wider uppercase text-[10px] bg-emerald-500/10 dark:bg-emerald-450/15 px-2.5 py-0.5 rounded-full">Free</span>
                        </div>
                        <div class="bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-100/50 dark:border-indigo-900/60 rounded-2xl p-4 flex justify-between items-center mt-2 shadow-sm">
                            <div>
                                <span class="text-[10px] font-black text-indigo-950 dark:text-indigo-300 uppercase tracking-widest block">Total Payable</span>
                                <span class="text-[10px] text-slate-450 dark:text-slate-450 font-semibold mt-0.5 block">All taxes included</span>
                            </div>
                            <span class="text-lg font-black text-indigo-650 dark:text-indigo-405 tracking-tight">৳{{ number_format($course->price) }} BDT</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Payment Tabs & Transaction Input -->
            <div class="card p-8 space-y-6">
                <div>
                    <h4 class="text-base font-extrabold text-slate-900 dark:text-white">Choose Payment Method</h4>
                    <p class="text-xs text-slate-500 mt-1">Please select one of the channels below and complete the transfer.</p>
                </div>

                <form method="POST" action="{{ route('student.courses.enroll', $course) }}" class="space-y-6">
                    @csrf
                    
                    <!-- Hidden Input for payment method submission -->
                    <input type="hidden" name="payment_method" :value="paymentMethod">

                    <!-- Payment Method Tabs -->
                    <div class="grid grid-cols-2 gap-3 p-1.5 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-slate-900">
                        <button type="button" @click="paymentMethod = 'card'" :class="paymentMethod === 'card' ? 'bg-white text-indigo-650 dark:bg-slate-900 dark:text-indigo-400 shadow-sm font-extrabold' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'" class="py-3 rounded-xl text-sm transition flex items-center justify-center">
                            Credit/Debit Card
                        </button>
                        <button type="button" @click="paymentMethod = 'bkash'" :class="paymentMethod === 'bkash' ? 'bg-white text-rose-600 dark:bg-slate-900 dark:text-rose-450 shadow-sm font-extrabold' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400'" class="py-3 rounded-xl text-sm transition flex items-center justify-center">
                            bKash Wallet
                        </button>
                    </div>

                    <!-- Instruction Boxes -->
                    <div>
                        <!-- Card payment instructions -->
                        <div x-show="paymentMethod === 'card'" class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5 dark:bg-slate-800/20 dark:border-slate-800/60 space-y-3">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-400 uppercase tracking-wider">Merchant Card Number</span>
                                <button type="button" onclick="navigator.clipboard.writeText('1234-5678-9012-3456'); alert('Copied!')" class="text-indigo-650 dark:text-indigo-400 font-semibold hover:underline">Copy</button>
                            </div>
                            <p class="text-lg font-black tracking-widest text-slate-850 dark:text-slate-150">1234-5678-9012-3456</p>
                            <p class="text-[11px] leading-relaxed text-slate-500 dark:text-slate-400">
                                Transfer exactly <strong>৳{{ number_format($course->price) }} BDT</strong> from your bank account/card portal to our card number above.
                            </p>
                        </div>

                        <!-- bKash payment instructions -->
                        <div x-show="paymentMethod === 'bkash'" class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5 dark:bg-slate-800/20 dark:border-slate-800/60 space-y-3" style="display: none;">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-400 uppercase tracking-wider">bKash Account Number</span>
                                <button type="button" onclick="navigator.clipboard.writeText('01898956499'); alert('Copied!')" class="text-rose-600 dark:text-rose-400 font-semibold hover:underline">Copy</button>
                            </div>
                            <p class="text-lg font-black tracking-widest text-slate-850 dark:text-slate-150">01898956499</p>
                            <p class="text-[11px] leading-relaxed text-slate-500 dark:text-slate-400">
                                Send Money exactly <strong>৳{{ number_format($course->price) }} BDT</strong> to our bKash personal number above.
                            </p>
                        </div>
                    </div>

                    <!-- Errors Alert -->
                    @if ($errors->any())
                        <div class="rounded-2xl border border-rose-100 bg-rose-50/50 p-4 text-rose-800 dark:bg-rose-950/20 dark:border-rose-900/60 dark:text-rose-300">
                            <ul class="list-disc pl-4.5 space-y-1 text-xs font-semibold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Transaction Input Field -->
                    <div class="space-y-2">
                        <label for="transaction_id" class="flex items-center gap-1">
                            <span>Transaction ID (TxID)</span>
                            <span class="text-rose-500 font-bold">*</span>
                        </label>
                        <input type="text" id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}" placeholder="e.g. TR5763A9K" class="mt-1" required>
                        <p class="text-[10px] text-slate-400 dark:text-slate-550 leading-relaxed">
                            Input the transaction reference code received after completing the payment transfer.
                        </p>
                    </div>

                    <!-- Submit Actions -->
                    <div class="pt-4 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end gap-3">
                        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-secondary text-xs px-5 py-2.5">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary text-xs px-6 py-2.5 flex items-center gap-1.5 shadow-lg shadow-indigo-650/10">
                            Verify & Enroll
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
