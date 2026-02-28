<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl text-center lg:text-left font-bold text-[#212529] dark:text-white">Buat Akun Baru</h1>
        <p class="text-sm text-[#6C757D] mt-1 text-center lg:text-left">Daftarkan diri Anda ke sistem EVDesign</p>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 bg-[#DC3545]/10 border border-[#DC3545]/30 rounded-lg">
            <p class="text-sm text-[#DC3545] font-medium flex items-center gap-1.5">
                <iconify-icon icon="solar:danger-circle-bold"></iconify-icon>
                {{ $errors->first() }}
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-[#212529] dark:text-white mb-1.5">Nama Lengkap</label>
            <div class="relative">
                <iconify-icon icon="solar:user-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6C757D] text-lg pointer-events-none"></iconify-icon>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       placeholder="Ahmad Perajin"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#F8F9FA] dark:bg-[#1E1E1E] border border-[#E9ECEF] dark:border-[#334155] rounded-lg text-sm text-[#212529] dark:text-white placeholder-[#6C757D] transition-all focus:outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-[#212529] dark:text-white mb-1.5">Email</label>
            <div class="relative">
                <iconify-icon icon="solar:letter-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6C757D] text-lg pointer-events-none"></iconify-icon>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       placeholder="admin@evdesign.id"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#F8F9FA] dark:bg-[#1E1E1E] border border-[#E9ECEF] dark:border-[#334155] rounded-lg text-sm text-[#212529] dark:text-white placeholder-[#6C757D] transition-all focus:outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-[#212529] dark:text-white mb-1.5">Password</label>
            <div class="relative">
                <iconify-icon icon="solar:lock-password-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6C757D] text-lg pointer-events-none"></iconify-icon>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="Min. 8 karakter"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#F8F9FA] dark:bg-[#1E1E1E] border border-[#E9ECEF] dark:border-[#334155] rounded-lg text-sm text-[#212529] dark:text-white placeholder-[#6C757D] transition-all focus:outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-[#212529] dark:text-white mb-1.5">Konfirmasi Password</label>
            <div class="relative">
                <iconify-icon icon="solar:lock-keyhole-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6C757D] text-lg pointer-events-none"></iconify-icon>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-4 py-2.5 bg-[#F8F9FA] dark:bg-[#1E1E1E] border border-[#E9ECEF] dark:border-[#334155] rounded-lg text-sm text-[#212529] dark:text-white placeholder-[#6C757D] transition-all focus:outline-none focus:border-[#fc1919] focus:ring-2 focus:ring-[#fc1919]/20">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full py-3 px-4 bg-[#fc1919] hover:bg-[#e01414] text-white font-semibold text-sm rounded-lg transition-all duration-200 hover:-translate-y-0.5 shadow-sm hover:shadow-md flex items-center justify-center gap-2 mt-2">
            <iconify-icon icon="solar:user-plus-bold"></iconify-icon>
            Buat Akun
        </button>

        <p class="text-center text-sm text-[#6C757D]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#fc1919] font-semibold hover:underline">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
