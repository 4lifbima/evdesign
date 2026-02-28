@extends('layouts.dashboard')
@section('title', 'Data Perajin')
@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#212529] dark:text-white">Data Perajin Binaan</h2>
        <p class="text-sm text-[#6C757D] mt-0.5">Kelola perajin Wastra Gorontalo</p>
    </div>
    <a href="{{ route('artisans.create') }}"
       class="inline-flex items-center gap-2 bg-[#fc1919] hover:bg-[#e01414] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm">
        <iconify-icon icon="solar:user-plus-bold" class="text-xl"></iconify-icon>
        Tambah Perajin
    </a>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-xl p-4 border border-[#E9ECEF] dark:border-[#334155] mb-4 shadow-sm">
    <form class="flex flex-wrap gap-3 items-center" method="GET">
        <div class="flex items-center bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 flex-1 min-w-[200px] focus-within:border-[#fc1919] focus-within:ring-1 ring-[#fc1919] transition-all">
            <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] mr-2"></iconify-icon>
            <input type="text" name="q" placeholder="Cari nama perajin..." value="{{ request('q') }}"
                   class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D]">
        </div>
        <select name="status" class="bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 text-sm text-[#212529] dark:text-white outline-none focus:border-[#fc1919]">
            <option value="">Status: Semua</option>
            <option value="active" @selected(request('status')==='active')>Aktif</option>
            <option value="inactive" @selected(request('status')==='inactive')>Nonaktif</option>
            <option value="on_leave" @selected(request('status')==='on_leave')>Cuti</option>
        </select>
        <button type="submit" class="bg-[#212529] dark:bg-[#334155] hover:bg-[#fc1919] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Filter</button>
        @if(request()->anyFilled(['q','status']))
            <a href="{{ route('artisans.index') }}" class="px-4 py-2 border border-[#E9ECEF] dark:border-[#334155] text-[#6C757D] hover:text-[#fc1919] rounded-lg text-sm transition-colors">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E9ECEF] dark:border-[#334155] overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[640px]">
            <thead>
                <tr class="bg-[#F8F9FA] dark:bg-[#121212] text-xs uppercase tracking-wide text-[#6C757D] border-b border-[#E9ECEF] dark:border-[#334155]">
                    <th class="py-4 px-5 font-semibold">Perajin</th>
                    <th class="py-4 px-5 font-semibold">Kontak</th>
                    <th class="py-4 px-5 font-semibold">Lokasi</th>
                    <th class="py-4 px-5 font-semibold">Bergabung</th>
                    <th class="py-4 px-5 font-semibold text-center">Status</th>
                    <th class="py-4 px-5 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E9ECEF] dark:divide-[#334155]">
                @forelse($artisans as $artisan)
                    @php
                        $initials = collect(explode(' ', $artisan->name))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('');
                        $colors = ['bg-[#fc1919]','bg-[#17A2B8]','bg-[#28A745]','bg-[#6f42c1]','bg-[#fd7e14]'];
                        $bg = $colors[$artisan->id % count($colors)];
                        $statusBadge = ['active'=>'badge-success','inactive'=>'badge-danger','on_leave'=>'badge-warning'];
                        $statusLabel = ['active'=>'Aktif','inactive'=>'Nonaktif','on_leave'=>'Cuti'];
                    @endphp
                    <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors">
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $bg }} flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-[#212529] dark:text-white">{{ $artisan->name }}</p>
                                    <p class="text-xs text-[#6C757D]">{{ implode(', ', array_slice($artisan->skills ?? [], 0, 2)) ?: '–' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-sm text-[#495057] dark:text-gray-400">
                            <p>{{ $artisan->email ?? '–' }}</p>
                            <p class="text-xs text-[#6C757D]">{{ $artisan->phone ?? '' }}</p>
                        </td>
                        <td class="py-4 px-5 text-sm text-[#495057] dark:text-gray-400">{{ $artisan->city ?? '–' }}, {{ $artisan->province ?? '' }}</td>
                        <td class="py-4 px-5 text-sm text-[#6C757D]">
                            {{ $artisan->joined_date ? $artisan->joined_date->format('d M Y') : '–' }}
                        </td>
                        <td class="py-4 px-5 text-center">
                            <span class="{{ $statusBadge[$artisan->status] ?? 'badge-info' }} px-3 py-1 rounded-full text-xs font-semibold inline-block">
                                {{ $statusLabel[$artisan->status] ?? ucfirst($artisan->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('artisans.edit', $artisan) }}"
                                   class="p-2 bg-gray-100 dark:bg-gray-800 text-[#6C757D] hover:text-[#fc1919] rounded-lg transition-colors" title="Edit">
                                    <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                </a>
                                <form action="{{ route('artisans.destroy', $artisan) }}" method="POST" class="inline">
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
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-[#6C757D]">
                                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-5xl opacity-30"></iconify-icon>
                                <p class="text-sm">Belum ada perajin. <a href="{{ route('artisans.create') }}" class="text-[#fc1919] hover:underline font-medium">Tambah sekarang →</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $artisans->withQueryString()->links() }}
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus data perajin ini?\nTindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
