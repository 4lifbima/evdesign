@extends('layouts.dashboard')
@section('title', 'Inventaris Bahan')
@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#212529] dark:text-white">Inventaris Bahan</h2>
        <p class="text-sm text-[#6C757D] mt-0.5">Kelola stok bahan baku produksi</p>
    </div>
    <a href="{{ route('materials.create') }}"
       class="inline-flex items-center gap-2 bg-[#fc1919] hover:bg-[#e01414] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-xl"></iconify-icon>
        Tambah Bahan
    </a>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-xl p-4 border border-[#E9ECEF] dark:border-[#334155] mb-4 shadow-sm">
    <form class="flex flex-wrap gap-3 items-center" method="GET">
        <div class="flex items-center bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 flex-1 min-w-[200px] focus-within:border-[#fc1919] focus-within:ring-1 ring-[#fc1919] transition-all">
            <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] mr-2"></iconify-icon>
            <input type="text" name="q" placeholder="Cari nama bahan..." value="{{ request('q') }}"
                   class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D]">
        </div>
        <button type="submit" class="bg-[#212529] dark:bg-[#334155] hover:bg-[#fc1919] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Cari</button>
        @if(request('q'))
            <a href="{{ route('materials.index') }}" class="px-4 py-2 border border-[#E9ECEF] dark:border-[#334155] text-[#6C757D] hover:text-[#fc1919] rounded-lg text-sm transition-colors">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E9ECEF] dark:border-[#334155] overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[680px]">
            <thead>
                <tr class="bg-[#F8F9FA] dark:bg-[#121212] text-xs uppercase tracking-wide text-[#6C757D] border-b border-[#E9ECEF] dark:border-[#334155]">
                    <th class="py-4 px-5 font-semibold">Bahan</th>
                    <th class="py-4 px-5 font-semibold">Kategori</th>
                    <th class="py-4 px-5 font-semibold">Satuan</th>
                    <th class="py-4 px-5 font-semibold">Harga/Unit</th>
                    <th class="py-4 px-5 font-semibold">Stok</th>
                    <th class="py-4 px-5 font-semibold text-center">Status</th>
                    <th class="py-4 px-5 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E9ECEF] dark:divide-[#334155]">
                @forelse($materials as $material)
                    @php
                        $stock    = $material->stock ?? 0;
                        $minStock = $material->minimum_stock ?? 5;
                        $pct      = $minStock > 0 ? min(100, round(($stock / max($minStock * 5, 1)) * 100)) : 100;
                        $critical = $stock <= $minStock;
                    @endphp
                    <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors">
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                                    <iconify-icon icon="solar:box-bold" class="text-[#6C757D]"></iconify-icon>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-[#212529] dark:text-white">{{ $material->name }}</p>
                                    <p class="text-xs text-[#6C757D]">{{ $material->supplier ?? '–' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-sm text-[#495057] dark:text-gray-400">{{ $material->category ?? '–' }}</td>
                        <td class="py-4 px-5 text-sm text-[#495057] dark:text-gray-400">{{ $material->unit }}</td>
                        <td class="py-4 px-5 text-sm font-mono text-[#6C757D]">
                            {{ $material->cost_per_unit ? 'Rp '.number_format($material->cost_per_unit, 0, ',', '.') : '–' }}
                        </td>
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-2 min-w-[100px]">
                                <div class="flex-1 h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $critical ? 'bg-[#DC3545]' : 'bg-[#28A745]' }}" style="width:{{ $pct }}%"></div>
                                </div>
                                <span class="font-mono text-xs font-bold {{ $critical ? 'text-[#DC3545]' : 'text-[#212529] dark:text-white' }}">{{ $stock }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-center">
                            @if($critical)
                                <span class="badge-danger px-3 py-1 rounded-full text-xs font-semibold inline-block">Kritis</span>
                            @elseif($material->is_active)
                                <span class="badge-success px-3 py-1 rounded-full text-xs font-semibold inline-block">Tersedia</span>
                            @else
                                <span class="badge-warning px-3 py-1 rounded-full text-xs font-semibold inline-block">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('materials.edit', $material) }}"
                                   class="p-2 bg-gray-100 dark:bg-gray-800 text-[#6C757D] hover:text-[#fc1919] rounded-lg transition-colors" title="Edit">
                                    <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                </a>
                                <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline">
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
                        <td colspan="7" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-[#6C757D]">
                                <iconify-icon icon="solar:box-bold-duotone" class="text-5xl opacity-30"></iconify-icon>
                                <p class="text-sm">Belum ada data bahan. <a href="{{ route('materials.create') }}" class="text-[#fc1919] hover:underline font-medium">Tambah sekarang →</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $materials->withQueryString()->links() }}
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus data bahan ini?\nTindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
