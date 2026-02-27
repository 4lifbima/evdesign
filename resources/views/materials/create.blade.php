@extends('layouts.dashboard')
@section('title', 'Tambah Bahan')
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('materials.index') }}" class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
        <iconify-icon icon="solar:arrow-left-linear" class="text-xl"></iconify-icon>
    </a>
    <div>
        <h2 class="text-xl font-semibold text-slate-900 dark:text-slate-100">Tambah Bahan</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Isi data dengan lengkap</p>
    </div>
</div>

<form action="{{ route('materials.store') }}" method="POST" class="space-y-6">
    @csrf
    @include('materials._form')
    <div class="flex items-center gap-3">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
            <iconify-icon icon="solar:diskette-bold" class="text-base"></iconify-icon> Simpan
        </button>
        <a href="{{ route('materials.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 text-sm font-medium rounded-xl transition">
            Batal
        </a>
    </div>
</form>
@endsection
