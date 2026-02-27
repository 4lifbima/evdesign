@extends('layouts.dashboard')
@section('title', 'Manajemen Kategori')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
    <div class="flex justify-between mb-4">
        <form class="flex gap-2" method="GET">
            <input type="text" name="q" placeholder="Cari kategori" value="{{ request('q') }}" class="rounded-xl border-slate-300 dark:bg-slate-800">
            <button class="px-3 py-2 bg-slate-800 text-white rounded-xl">Cari</button>
        </form>
        <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-xl">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead><tr class="border-b border-slate-200 dark:border-slate-800"><th class="py-2">Nama</th><th>Parent</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
            <tbody>
            @forelse($categories as $category)
                <tr class="border-b border-slate-100 dark:border-slate-800">
                    <td class="py-2">{{ $category->name }}</td><td>{{ $category->parent?->name ?? '-' }}</td><td>{{ $category->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="text-right space-x-2">
                        <a href="{{ route('categories.show',$category) }}" class="text-blue-600">Detail</a>
                        <a href="{{ route('categories.edit',$category) }}" class="text-amber-600">Edit</a>
                        <form action="{{ route('categories.destroy',$category) }}" method="POST" class="inline">@csrf @method('DELETE')<button onclick="return confirm('Hapus data?')" class="text-red-600">Hapus</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-3 text-slate-500">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $categories->links() }}</div>
</div>
@endsection
