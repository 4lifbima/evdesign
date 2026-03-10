<section class="space-y-6">
    <header class="mb-6 flex items-start gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 flex-shrink-0">
            <iconify-icon icon="solar:shield-warning-bold" class="text-2xl"></iconify-icon>
        </div>
        <div>
            <h2 class="text-xl font-bold text-red-600 dark:text-red-400">
                Hapus Akun Permanen
            </h2>
            <p class="mt-1 text-sm text-red-500/80 dark:text-red-300/80">
                Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus, harap unduh data apa pun yang ingin Anda simpan.
            </p>
        </div>
    </header>

    <button type="button" 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 text-white font-semibold flex items-center gap-2 px-6 py-2.5 rounded-xl transition-all shadow-md active:scale-95">
        <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
        Ya, Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8 bg-white dark:bg-[#1E1E1E]">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-[#212529] dark:text-white flex items-center gap-2">
                <iconify-icon icon="solar:danger-triangle-bold" class="text-red-600"></iconify-icon>
                Apakah Anda yakin ingin menghapus sistem akun ini?
            </h2>

            <p class="mt-2 text-sm text-[#6C757D] dark:text-gray-400">
                Tindakan ini tidak dapat diurungkan. Semua data Anda akan lenyap. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Kata Sandi</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full sm:w-3/4 bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] text-[#212529] dark:text-white rounded-xl px-4 py-2.5 focus:border-red-500 focus:ring focus:ring-red-500/20 transition-all outline-none"
                    placeholder="Masukkan Kata Sandi"
                />

                @if($errors->userDeletion->has('password'))
                    <p class="mt-2 text-sm text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-[#212529] dark:text-white font-semibold rounded-xl transition-colors">
                    Batal
                </button>

                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl flex items-center gap-2 shadow-md transition-colors">
                    Hapus Akun Permanen
                </button>
            </div>
        </form>
    </x-modal>
</section>
