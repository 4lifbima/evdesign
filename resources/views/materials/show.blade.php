@extends('layouts.dashboard')
@section('title', 'Detail Material')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-2"><p><strong>Nama:</strong> {{ $material->name }}</p><p><strong>Stok:</strong> {{ $material->stock }} {{ $material->unit }}</p><p><strong>Supplier:</strong> {{ $material->supplier ?? '-' }}</p><h3 class="font-semibold mt-4">Riwayat Stok</h3><ul class="list-disc pl-5">@forelse($material->stockHistories->take(10) as $history)<li>{{ $history->type }} | {{ $history->stock_before }} -> {{ $history->stock_after }} | {{ $history->created_at->format('d M Y H:i') }}</li>@empty<li>Tidak ada riwayat.</li>@endforelse</ul></div>
@endsection
