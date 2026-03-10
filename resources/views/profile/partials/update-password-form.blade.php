<section>
    <header class="mb-6 flex items-start gap-4">
        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[#212529] dark:text-white flex-shrink-0">
            <iconify-icon icon="solar:lock-keyhole-bold" class="text-2xl"></iconify-icon>
        </div>
        <div>
            <h2 class="text-xl font-bold text-[#212529] dark:text-white">
                Perbarui Kata Sandi
            </h2>
            <p class="mt-1 text-sm text-[#6C757D] dark:text-gray-400">
                Pastikan akun Anda menggunakan kata sandi panjang dan acak agar tetap aman.
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-[#212529] dark:text-gray-300 mb-1">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] text-[#212529] dark:text-white rounded-xl px-4 py-2.5 focus:border-[#fc1919] focus:ring focus:ring-[#fc1919]/20 transition-all outline-none" autocomplete="current-password" />
            @if($errors->updatePassword->has('current_password'))
                <p class="mt-2 text-sm text-[#fc1919]">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block font-medium text-sm text-[#212529] dark:text-gray-300 mb-1">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" class="w-full bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] text-[#212529] dark:text-white rounded-xl px-4 py-2.5 focus:border-[#fc1919] focus:ring focus:ring-[#fc1919]/20 transition-all outline-none" autocomplete="new-password" />
            @if($errors->updatePassword->has('password'))
                <p class="mt-2 text-sm text-[#fc1919]">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-[#212529] dark:text-gray-300 mb-1">Konfirmasi Kata Sandi Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] text-[#212529] dark:text-white rounded-xl px-4 py-2.5 focus:border-[#fc1919] focus:ring focus:ring-[#fc1919]/20 transition-all outline-none" autocomplete="new-password" />
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="mt-2 text-sm text-[#fc1919]">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-[#212529] dark:bg-white dark:text-black dark:hover:bg-gray-200 hover:bg-black text-white font-semibold flex items-center gap-2 px-6 py-2.5 rounded-xl transition-all shadow-md active:scale-95">
                <iconify-icon icon="solar:shield-check-bold"></iconify-icon>
                Simpan Kata Sandi
            </button>
        </div>
    </form>
</section>
