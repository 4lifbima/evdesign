@extends('layouts.dashboard')
@section('title', 'Pengaturan')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Pengaturan Sistem</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Konfigurasi key-value untuk sistem EVDesign</p>
    </div>
    <a href="{{ route('settings.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition duration-150 shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-lg"></iconify-icon>
        Tambah Setting
    </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 mb-4">
    <form class="flex flex-col sm:flex-row gap-3" method="GET">
        <div class="relative flex-1">
            <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></iconify-icon>
            <input type="text" name="q" placeholder="Cari setting key..." value="{{ request('q') }}"
                   class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-sm font-medium rounded-xl transition">Cari</button>
        @if(request('q'))
            <a href="{{ route('settings.index') }}" class="px-4 py-2 text-slate-500 dark:text-slate-400 hover:text-red-600 text-sm rounded-xl border border-slate-200 dark:border-slate-700 transition text-center">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Key</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Group</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Type</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Value</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settings as $setting)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 font-mono font-medium text-slate-900 dark:text-slate-100 text-xs">{{ $setting->key }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">{{ $setting->group }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $typeColors = ['text' => 'blue', 'textarea' => 'purple', 'image' => 'rose', 'boolean' => 'teal', 'number' => 'amber'];
                                $c = $typeColors[$setting->type] ?? 'slate';
                            @endphp
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-medium bg-{{ $c }}-100 dark:bg-{{ $c }}-500/20 text-{{ $c }}-700 dark:text-{{ $c }}-400">{{ $setting->type }}</span>
                        </td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400 max-w-xs truncate">
                            {{ Str::limit($setting->value, 40) ?? '–' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('settings.show', $setting) }}" class="p-1.5 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition" title="Detail">
                                    <iconify-icon icon="solar:eye-bold" class="text-base"></iconify-icon>
                                </a>
                                <a href="{{ route('settings.edit', $setting) }}" class="p-1.5 rounded-lg text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition" title="Edit">
                                    <iconify-icon icon="solar:pen-bold" class="text-base"></iconify-icon>
                                </a>
                                <form action="{{ route('settings.destroy', $setting) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this.closest('form'))" class="p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition" title="Hapus">
                                        <iconify-icon icon="solar:trash-bin-trash-bold" class="text-base"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-400 dark:text-slate-600">
                                <iconify-icon icon="solar:settings-bold-duotone" class="text-4xl"></iconify-icon>
                                <p class="text-sm">Belum ada konfigurasi. <a href="{{ route('settings.create') }}" class="text-red-600 dark:text-red-400 hover:underline">Tambah sekarang</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($settings->hasPages())
    <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-800">{{ $settings->withQueryString()->links() }}</div>
    @endif
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus konfigurasi ini? Tindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
