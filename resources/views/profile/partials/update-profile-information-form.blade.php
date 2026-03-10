<section>
    <header class="mb-6 flex items-start gap-4">
        <div class="w-12 h-12 rounded-xl bg-[#fc1919]/10 flex items-center justify-center text-[#fc1919] flex-shrink-0">
            <iconify-icon icon="solar:user-id-bold" class="text-2xl"></iconify-icon>
        </div>
        <div>
            <h2 class="text-xl font-bold text-[#212529] dark:text-white">
                Informasi Profil
            </h2>
            <p class="mt-1 text-sm text-[#6C757D] dark:text-gray-400">
                Perbarui detail akun dan alamat email Anda di sini.
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block font-medium text-sm text-[#212529] dark:text-gray-300 mb-1">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="w-full bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] text-[#212529] dark:text-white rounded-xl px-4 py-2.5 focus:border-[#fc1919] focus:ring focus:ring-[#fc1919]/20 transition-all outline-none" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <p class="mt-2 text-sm text-[#fc1919]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block font-medium text-sm text-[#212529] dark:text-gray-300 mb-1">Alamat Email</label>
            <input id="email" name="email" type="email" class="w-full bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] text-[#212529] dark:text-white rounded-xl px-4 py-2.5 focus:border-[#fc1919] focus:ring focus:ring-[#fc1919]/20 transition-all outline-none" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <p class="mt-2 text-sm text-[#fc1919]">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400 rounded-lg text-sm">
                    <p class="mb-2">Alamat email Anda belum diverifikasi.</p>
                    <button form="send-verification" class="text-sm font-semibold underline hover:text-yellow-900 transition-colors">
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-600 dark:text-green-400 font-medium">Link verifikasi baru telah dikirim ke email Anda.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-[#fc1919] hover:bg-red-700 text-white font-semibold flex items-center gap-2 px-6 py-2.5 rounded-xl transition-all shadow-md shadow-red-500/20 active:scale-95">
                <iconify-icon icon="solar:disk-bold"></iconify-icon>
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>
