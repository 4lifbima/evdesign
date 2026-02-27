@extends('layouts.dashboard')
@section('title', 'Manajemen Produk')
@section('content')

{{-- Header + Actions --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Manajemen Produk</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Kelola produk unggulan EVDesign</p>
    </div>
    <a href="{{ route('products.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition duration-150 shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-lg"></iconify-icon>
        Tambah Produk
    </a>
</div>

{{-- Filters --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 mb-4">
    <form class="flex flex-col sm:flex-row gap-3" method="GET">
        <div class="relative flex-1">
            <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></iconify-icon>
            <input type="text" name="q" placeholder="Cari produk..." value="{{ request('q') }}"
                   class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
        </div>
        <select name="status" class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
            <option value="">Semua Status</option>
            <option value="draft" @selected(request('status')==='draft')>Draft</option>
            <option value="published" @selected(request('status')==='published')>Published</option>
            <option value="archived" @selected(request('status')==='archived')>Archived</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white text-sm font-medium rounded-xl transition">
            Filter
        </button>
        @if(request('q') || request('status'))
            <a href="{{ route('products.index') }}" class="px-4 py-2 text-slate-500 dark:text-slate-400 hover:text-red-600 text-sm rounded-xl border border-slate-200 dark:border-slate-700 transition text-center">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left min-w-[700px]">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Nama Produk</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Kategori</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Harga</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Stok</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300">Status</th>
                    <th class="px-4 py-3 font-semibold text-slate-600 dark:text-slate-300 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 font-medium text-slate-900 dark:text-slate-100">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $product->category?->name ?? '–' }}</td>
                        <td class="px-4 py-3 font-mono text-slate-700 dark:text-slate-300">Rp {{ number_format((float)$product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                            @if($product->stock <= 5)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-xs font-medium">
                                    <iconify-icon icon="solar:danger-triangle-bold"></iconify-icon> {{ $product->stock }}
                                </span>
                            @else
                                <span class="text-slate-600 dark:text-slate-400">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusClasses = [
                                    'published' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400',
                                    'draft'     => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
                                    'archived'  => 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400',
                                ];
                                $cls = $statusClasses[$product->status] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold {{ $cls }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.show', $product) }}"
                                   class="p-1.5 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition" title="Detail">
                                    <iconify-icon icon="solar:eye-bold" class="text-base"></iconify-icon>
                                </a>
                                <a href="{{ route('products.edit', $product) }}"
                                   class="p-1.5 rounded-lg text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition" title="Edit">
                                    <iconify-icon icon="solar:pen-bold" class="text-base"></iconify-icon>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this.closest('form'))"
                                            class="p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition" title="Hapus">
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
                                <p class="text-sm">Belum ada produk. <a href="{{ route('products.create') }}" class="text-red-600 dark:text-red-400 hover:underline">Tambah sekarang</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-800">{{ $products->withQueryString()->links() }}</div>
    @endif
</div>

<script>
function confirmDelete(form) {
    Toastify({
        text: "Yakin ingin menghapus data ini?",
        duration: -1,
        close: false,
        gravity: "top",
        position: "center",
        style: { background: "linear-gradient(to right, #1e293b, #334155)", borderRadius: "12px", padding: "16px 24px" },
        onClick: function() {}
    });
    if (confirm('Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
