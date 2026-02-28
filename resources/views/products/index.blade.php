@extends('layouts.dashboard')
@section('title', 'Manajemen Produk')
@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#212529] dark:text-white">Daftar Produk</h2>
        <p class="text-sm text-[#6C757D] mt-0.5">Kelola produk unggulan EVDesign Wastra</p>
    </div>
    <a href="{{ route('products.create') }}"
       class="inline-flex items-center gap-2 bg-[#fc1919] hover:bg-[#e01414] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-xl"></iconify-icon>
        Tambah Produk Baru
    </a>
</div>

{{-- Filter Bar --}}
<div class="bg-white dark:bg-[#1E1E1E] rounded-xl p-4 border border-[#E9ECEF] dark:border-[#334155] mb-4 shadow-sm">
    <form class="flex flex-wrap gap-3 items-center" method="GET">
        <div class="flex items-center bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 flex-1 min-w-[200px] focus-within:border-[#fc1919] focus-within:ring-1 ring-[#fc1919] transition-all">
            <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] mr-2"></iconify-icon>
            <input type="text" name="q" placeholder="Cari nama produk..." value="{{ request('q') }}"
                   class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D]">
        </div>
        <select name="status" class="bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 text-sm text-[#212529] dark:text-white outline-none focus:border-[#fc1919] min-w-[160px]">
            <option value="">Status: Semua</option>
            <option value="published" @selected(request('status')==='published')>Published</option>
            <option value="draft" @selected(request('status')==='draft')>Draft</option>
            <option value="archived" @selected(request('status')==='archived')>Archived</option>
        </select>
        <button type="submit" class="bg-[#212529] dark:bg-[#334155] hover:bg-[#fc1919] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            Filter
        </button>
        @if(request()->anyFilled(['q','status']))
            <a href="{{ route('products.index') }}" class="px-4 py-2 border border-[#E9ECEF] dark:border-[#334155] text-[#6C757D] hover:text-[#fc1919] hover:border-[#fc1919] rounded-lg text-sm transition-colors">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E9ECEF] dark:border-[#334155] overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-[#F8F9FA] dark:bg-[#121212] text-xs uppercase tracking-wide text-[#6C757D] border-b border-[#E9ECEF] dark:border-[#334155]">
                    <th class="py-4 px-5 font-semibold">Info Produk</th>
                    <th class="py-4 px-5 font-semibold">Kategori</th>
                    <th class="py-4 px-5 font-semibold">Harga</th>
                    <th class="py-4 px-5 font-semibold text-center">Stok</th>
                    <th class="py-4 px-5 font-semibold text-center">Status</th>
                    <th class="py-4 px-5 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E9ECEF] dark:divide-[#334155]">
                @forelse($products as $product)
                    <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors group">
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    <iconify-icon icon="solar:bag-bold" class="text-xl text-[#6C757D]"></iconify-icon>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-[#212529] dark:text-white">{{ Str::limit($product->name, 40) }}</p>
                                    <p class="text-xs text-[#6C757D] mt-0.5">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-sm text-[#495057] dark:text-gray-400">{{ $product->category?->name ?? '–' }}</td>
                        <td class="py-4 px-5 text-sm font-mono font-semibold text-[#212529] dark:text-white">Rp {{ number_format((float)$product->price, 0, ',', '.') }}</td>
                        <td class="py-4 px-5 text-sm text-center">
                            @if(($product->stock ?? 0) <= 5)
                                <span class="badge-danger px-2 py-0.5 rounded-full text-xs font-semibold inline-block">{{ $product->stock ?? 0 }} ⚠</span>
                            @else
                                <span class="font-mono text-[#212529] dark:text-white font-semibold">{{ $product->stock ?? 0 }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-center">
                            @php $bs=['published'=>'badge-success','draft'=>'badge-warning','archived'=>'badge-danger']; @endphp
                            <span class="{{ $bs[$product->status] ?? '' }} px-3 py-1 rounded-full text-xs font-semibold inline-block">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="p-2 bg-gray-100 dark:bg-gray-800 text-[#6C757D] hover:text-[#fc1919] rounded-lg transition-colors" title="Edit">
                                    <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline delete-form">
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
                                <iconify-icon icon="solar:bag-bold-duotone" class="text-5xl opacity-30"></iconify-icon>
                                <p class="text-sm">Belum ada produk. <a href="{{ route('products.create') }}" class="text-[#fc1919] hover:underline font-medium">Tambah sekarang →</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $products->withQueryString()->links() }}
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus data ini?\nTindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
