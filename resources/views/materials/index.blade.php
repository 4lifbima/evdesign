@extends('layouts.dashboard')
@section('title', 'Inventaris Bahan')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Inventaris Bahan</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Pantau stok bahan material produksi</p>
    </div>
    <a href="{{ route('materials.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition duration-150 shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-lg"></iconify-icon>
        Tambah Bahan
    </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 mb-4">
    <form class="flex flex-col sm:flex-row gap-3" method="GET">
        <div class="relative flex-1">
            <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></iconify-icon>
            <input type="text" name="q" placeholder="Cari bahan material..." value="{{ request('q') }}"
                   class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-sm font-medium rounded-xl transition">Cari</button>
        @if(request('q'))
            <a href="{{ route('materials.index') }}" class="px-4 py-2 text-slate-500 dark:text-slate-400 hover:text-red-600 text-sm rounded-xl border border-slate-200 dark:border-slate-700 transition text-center">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Nama Bahan</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Stok</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Unit</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Harga per Unit</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Status</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 font-medium text-slate-900 dark:text-slate-100">{{ $material->name }}</td>
                        <td class="px-4 py-3">
                            @php $lowStock = $material->stock <= ($material->min_stock ?? 10); @endphp
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 w-20">
                                    @php $pct = $lowStock ? 20 : min(100, ($material->stock / max(100, $material->stock)) * 100); @endphp
                                    <div class="h-1.5 rounded-full {{ $lowStock ? 'bg-red-500' : 'bg-emerald-500' }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="{{ $lowStock ? 'text-red-600 dark:text-red-400' : 'text-slate-600 dark:text-slate-400' }} font-mono text-xs">{{ $material->stock }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $material->unit ?? '–' }}</td>
                        <td class="px-4 py-3 font-mono text-slate-700 dark:text-slate-300">
                            {{ $material->price_per_unit ? 'Rp ' . number_format($material->price_per_unit, 0, ',', '.') : '–' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($material->is_active)
                                <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400">Aktif</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('materials.show', $material) }}" class="p-1.5 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition" title="Detail">
                                    <iconify-icon icon="solar:eye-bold" class="text-base"></iconify-icon>
                                </a>
                                <a href="{{ route('materials.edit', $material) }}" class="p-1.5 rounded-lg text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition" title="Edit">
                                    <iconify-icon icon="solar:pen-bold" class="text-base"></iconify-icon>
                                </a>
                                <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline">
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
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-400 dark:text-slate-600">
                                <iconify-icon icon="solar:box-bold-duotone" class="text-4xl"></iconify-icon>
                                <p class="text-sm">Belum ada bahan terdaftar. <a href="{{ route('materials.create') }}" class="text-red-600 dark:text-red-400 hover:underline">Tambah sekarang</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($materials->hasPages())
    <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-800">{{ $materials->withQueryString()->links() }}</div>
    @endif
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus bahan ini? Tindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
