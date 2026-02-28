@extends('layouts.dashboard')
@section('title', 'Pengaturan')
@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#212529] dark:text-white">Pengaturan Sistem</h2>
        <p class="text-sm text-[#6C757D] mt-0.5">Konfigurasi aplikasi EVDesign</p>
    </div>
    <a href="{{ route('settings.create') }}"
       class="inline-flex items-center gap-2 bg-[#fc1919] hover:bg-[#e01414] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-xl"></iconify-icon>
        Tambah Setting
    </a>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-xl p-4 border border-[#E9ECEF] dark:border-[#334155] mb-4 shadow-sm">
    <form class="flex flex-wrap gap-3 items-center" method="GET">
        <div class="flex items-center bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 flex-1 min-w-[200px] focus-within:border-[#fc1919] focus-within:ring-1 ring-[#fc1919] transition-all">
            <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] mr-2"></iconify-icon>
            <input type="text" name="q" placeholder="Cari setting key..." value="{{ request('q') }}"
                   class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D]">
        </div>
        <select name="group" class="bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 text-sm text-[#212529] dark:text-white outline-none focus:border-[#fc1919]">
            <option value="">Semua Group</option>
            @foreach($settings->pluck('group')->unique()->filter() as $grp)
                <option value="{{ $grp }}" @selected(request('group')===$grp)>{{ ucfirst($grp) }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-[#212529] dark:bg-[#334155] hover:bg-[#fc1919] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Filter</button>
        @if(request()->anyFilled(['q','group']))
            <a href="{{ route('settings.index') }}" class="px-4 py-2 border border-[#E9ECEF] dark:border-[#334155] text-[#6C757D] hover:text-[#fc1919] rounded-lg text-sm transition-colors">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E9ECEF] dark:border-[#334155] overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-[#F8F9FA] dark:bg-[#121212] text-xs uppercase tracking-wide text-[#6C757D] border-b border-[#E9ECEF] dark:border-[#334155]">
                    <th class="py-4 px-5 font-semibold">Key</th>
                    <th class="py-4 px-5 font-semibold">Group</th>
                    <th class="py-4 px-5 font-semibold">Type</th>
                    <th class="py-4 px-5 font-semibold">Value</th>
                    <th class="py-4 px-5 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E9ECEF] dark:divide-[#334155]">
                @php
                    $typeBadge = ['text'=>'badge-info','textarea'=>'badge-info','image'=>'badge-success','boolean'=>'badge-warning','number'=>'badge-danger','color'=>'bg-purple-100 text-purple-700','file'=>'badge-success'];
                @endphp
                @forelse($settings as $setting)
                    <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors">
                        <td class="py-4 px-5">
                            <p class="font-bold text-sm font-mono text-[#212529] dark:text-white">{{ $setting->key }}</p>
                            @if($setting->description)
                                <p class="text-xs text-[#6C757D] mt-0.5">{{ Str::limit($setting->description, 50) }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-5">
                            <span class="badge-info px-3 py-1 rounded-full text-xs font-semibold inline-block capitalize">{{ $setting->group ?? '–' }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="{{ $typeBadge[$setting->type] ?? 'badge-info' }} px-3 py-1 rounded-full text-xs font-semibold inline-block">{{ $setting->type }}</span>
                        </td>
                        <td class="py-4 px-5 text-sm font-mono text-[#495057] dark:text-gray-400 max-w-[200px]">
                            <span class="truncate block">{{ Str::limit($setting->value ?? '', 40) }}</span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('settings.edit', $setting) }}"
                                   class="p-2 bg-gray-100 dark:bg-gray-800 text-[#6C757D] hover:text-[#fc1919] rounded-lg transition-colors" title="Edit">
                                    <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                </a>
                                <form action="{{ route('settings.destroy', $setting) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this.closest('form'))"
                                            class="p-2 bg-gray-100 dark:bg-gray-800 text-[#6C757D] hover:text-[#DC3545] rounded-lg transition-colors" title="Hapus">
                                        <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-[#6C757D]">
                                <iconify-icon icon="solar:settings-bold-duotone" class="text-5xl opacity-30"></iconify-icon>
                                <p class="text-sm">Belum ada pengaturan. <a href="{{ route('settings.create') }}" class="text-[#fc1919] hover:underline font-medium">Tambah sekarang →</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $settings->withQueryString()->links() }}
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus setting ini?\nTindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
