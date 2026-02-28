@extends('layouts.dashboard')
@section('title', 'Galeri Karya')
@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#212529] dark:text-white">Galeri Karya Wastra</h2>
        <p class="text-sm text-[#6C757D] mt-0.5">Tampilkan dokumentasi karya dan kegiatan</p>
    </div>
    <a href="{{ route('galleries.create') }}"
       class="inline-flex items-center gap-2 bg-[#fc1919] hover:bg-[#e01414] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm">
        <iconify-icon icon="solar:add-circle-bold" class="text-xl"></iconify-icon>
        Tambah Galeri
    </a>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-xl p-4 border border-[#E9ECEF] dark:border-[#334155] mb-4 shadow-sm">
    <form class="flex flex-wrap gap-3 items-center" method="GET">
        <div class="flex items-center bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 flex-1 min-w-[200px] focus-within:border-[#fc1919] focus-within:ring-1 ring-[#fc1919] transition-all">
            <iconify-icon icon="solar:magnifer-linear" class="text-[#6C757D] mr-2"></iconify-icon>
            <input type="text" name="q" placeholder="Cari judul galeri..." value="{{ request('q') }}"
                   class="bg-transparent border-none outline-none w-full text-sm text-[#212529] dark:text-white placeholder-[#6C757D]">
        </div>
        <select name="category" class="bg-[#F8F9FA] dark:bg-[#121212] border border-[#E9ECEF] dark:border-[#334155] rounded-lg px-3 py-2 text-sm text-[#212529] dark:text-white outline-none focus:border-[#fc1919]">
            <option value="">Semua Kategori</option>
            <option value="kegiatan" @selected(request('category')==='kegiatan')>Kegiatan</option>
            <option value="produk" @selected(request('category')==='produk')>Produk</option>
            <option value="proses" @selected(request('category')==='proses')>Proses Membuat</option>
            <option value="lainnya" @selected(request('category')==='lainnya')>Lainnya</option>
        </select>
        <button type="submit" class="bg-[#212529] dark:bg-[#334155] hover:bg-[#fc1919] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Filter</button>
        @if(request()->anyFilled(['q','category']))
            <a href="{{ route('galleries.index') }}" class="px-4 py-2 border border-[#E9ECEF] dark:border-[#334155] text-[#6C757D] hover:text-[#fc1919] rounded-lg text-sm transition-colors">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white dark:bg-[#1E1E1E] rounded-2xl border border-[#E9ECEF] dark:border-[#334155] overflow-hidden shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[640px]">
            <thead>
                <tr class="bg-[#F8F9FA] dark:bg-[#121212] text-xs uppercase tracking-wide text-[#6C757D] border-b border-[#E9ECEF] dark:border-[#334155]">
                    <th class="py-4 px-5 font-semibold">Karya</th>
                    <th class="py-4 px-5 font-semibold">Kategori</th>
                    <th class="py-4 px-5 font-semibold">Lokasi</th>
                    <th class="py-4 px-5 font-semibold">Tanggal Event</th>
                    <th class="py-4 px-5 font-semibold text-center">Featured</th>
                    <th class="py-4 px-5 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E9ECEF] dark:divide-[#334155]">
                @forelse($galleries as $gallery)
                    @php
                        $catColors = ['kegiatan'=>'badge-info','produk'=>'badge-success','proses'=>'badge-warning','lainnya'=>'bg-gray-100 text-gray-600'];
                    @endphp
                    <tr class="hover:bg-red-50/50 dark:hover:bg-red-900/10 transition-colors">
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100 dark:bg-gray-800">
                                    @if($gallery->thumbnail_path || $gallery->image_path)
                                        <img src="{{ asset('storage/'.($gallery->thumbnail_path ?? $gallery->image_path)) }}"
                                             class="w-full h-full object-cover" alt="{{ $gallery->title }}"
                                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                        <div class="w-full h-full items-center justify-center hidden">
                                            <iconify-icon icon="solar:gallery-bold" class="text-2xl text-[#6C757D]"></iconify-icon>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <iconify-icon icon="solar:gallery-bold" class="text-2xl text-[#6C757D]"></iconify-icon>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-[#212529] dark:text-white">{{ Str::limit($gallery->title, 38) }}</p>
                                    <p class="text-xs text-[#6C757D]">{{ $gallery->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-5">
                            <span class="{{ $catColors[$gallery->category] ?? 'badge-info' }} px-3 py-1 rounded-full text-xs font-semibold inline-block capitalize">
                                {{ $gallery->category }}
                            </span>
                        </td>
                        <td class="py-4 px-5 text-sm text-[#495057] dark:text-gray-400">{{ $gallery->location ?? '–' }}</td>
                        <td class="py-4 px-5 text-sm text-[#6C757D]">
                            {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '–' }}
                        </td>
                        <td class="py-4 px-5 text-center">
                            @if($gallery->is_featured)
                                <span class="badge-warning px-3 py-1 rounded-full text-xs font-semibold inline-block">★ Featured</span>
                            @else
                                <span class="text-[#6C757D] text-xs">–</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('galleries.edit', $gallery) }}"
                                   class="p-2 bg-gray-100 dark:bg-gray-800 text-[#6C757D] hover:text-[#fc1919] rounded-lg transition-colors" title="Edit">
                                    <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                </a>
                                <form action="{{ route('galleries.destroy', $gallery) }}" method="POST" class="inline">
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
                                <iconify-icon icon="solar:gallery-bold-duotone" class="text-5xl opacity-30"></iconify-icon>
                                <p class="text-sm">Belum ada galeri. <a href="{{ route('galleries.create') }}" class="text-[#fc1919] hover:underline font-medium">Tambah sekarang →</a></p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $galleries->withQueryString()->links() }}
</div>

<script>
function confirmDelete(form) {
    if (confirm('Yakin ingin menghapus galeri ini?\nTindakan ini tidak dapat dibatalkan.')) {
        form.submit();
    }
}
</script>
@endsection
