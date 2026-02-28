<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl text-center lg:text-left font-bold text-[#212529] dark:text-white">Selamat Datang Kembali</h1>
        <p class="text-sm text-[#6C757D] mt-1 text-center lg:text-left">Masuk ke akun EVDesign Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if($errors->any())
        <div class="mb-4 p-3 bg-[#DC3545]/10 border border-[#DC3545]/30 rounded-lg">
            <p class="text-sm text-[#DC3545] font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:danger-circle-bold"></iconify-icon>
                {{ $errors->first() }}
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-[#212529] dark:text-white mb-1.5">
                Email
            </label>
            <div class="relative">
                <iconify-icon icon="solar:letter-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6C757D] text-lg pointer-events-none"></iconify-icon>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="admin@evdesign.id"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#F8F9FA] dark:bg-[#1E1E1E] border border-[#E9ECEF] dark:border-[#334155] rounded-lg text-sm text-[#212529] dark:text-white placeholder-[#6C757D] transition-all focus:outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20">
            </div>
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-sm font-semibold text-[#212529] dark:text-white">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-[#fc1919] hover:underline font-medium">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <iconify-icon icon="solar:lock-password-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6C757D] text-lg pointer-events-none"></iconify-icon>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#F8F9FA] dark:bg-[#1E1E1E] border border-[#E9ECEF] dark:border-[#334155] rounded-lg text-sm text-[#212529] dark:text-white placeholder-[#6C757D] transition-all focus:outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20">
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-[#E9ECEF] dark:border-[#334155]"
                   style="accent-color:#fc1919">
            <label for="remember_me" class="text-sm text-[#6C757D] select-none cursor-pointer">Ingat saya</label>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full py-3 px-4 bg-[#fc1919] hover:bg-[#e01414] text-white font-semibold text-sm rounded-lg transition-all duration-200 hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
            <iconify-icon icon="solar:login-2-bold"></iconify-icon>
            Masuk ke Dashboard
        </button>

        <p class="text-center text-sm text-[#6C757D]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#fc1919] font-semibold hover:underline">Daftar di sini</a>
        </p>
    </form>
</x-guest-layout>
