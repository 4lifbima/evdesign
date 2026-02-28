<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl text-center lg:text-left font-bold text-[#212529] dark:text-white">Lupa Password?</h1>
        <p class="text-sm text-[#6C757D] mt-2 text-center lg:text-left leading-relaxed">
            Tidak masalah. Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.
        </p>
    </div>

    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-5 p-4 bg-[#28A745]/10 border border-[#28A745]/30 rounded-lg flex items-start gap-3">
            <iconify-icon icon="solar:check-circle-bold" class="text-[#28A745] text-xl flex-shrink-0 mt-0.5"></iconify-icon>
            <p class="text-sm text-[#28A745] font-medium">{{ session('status') }}</p>
        </div>
    @endif

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if($errors->any())
        <div class="mb-4 p-3 bg-[#DC3545]/10 border border-[#DC3545]/30 rounded-lg">
            <p class="text-sm text-[#DC3545] font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:danger-circle-bold"></iconify-icon>
                {{ $errors->first() }}
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-[#212529] dark:text-white mb-1.5">Alamat Email</label>
            <div class="relative">
                <iconify-icon icon="solar:letter-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6C757D] text-lg pointer-events-none"></iconify-icon>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="admin@evdesign.id"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#F8F9FA] dark:bg-[#1E1E1E] border border-[#E9ECEF] dark:border-[#334155] rounded-lg text-sm text-[#212529] dark:text-white placeholder-[#6C757D] transition-all focus:outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full py-3 px-4 bg-[#fc1919] hover:bg-[#e01414] text-white font-semibold text-sm rounded-lg transition-all duration-200 hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
            <iconify-icon icon="solar:letter-bold"></iconify-icon>
            Kirim Tautan Reset Password
        </button>

        <a href="{{ route('login') }}"
           class="w-full py-2.5 px-4 border border-[#E9ECEF] dark:border-[#334155] text-[#6C757D] hover:text-[#fc1919] hover:border-[#fc1919] text-sm rounded-lg transition-colors flex items-center justify-center gap-2 font-medium">
            <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
            Kembali ke halaman login
        </a>
    </form>
</x-guest-layout>
