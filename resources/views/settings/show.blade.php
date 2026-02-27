@extends('layouts.dashboard')
@section('title', 'Detail Setting')
@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-2"><p><strong>Key:</strong> {{ $setting->key }}</p><p><strong>Group:</strong> {{ $setting->group }}</p><p><strong>Type:</strong> {{ $setting->type }}</p><p><strong>Value:</strong> {{ $setting->value }}</p><p><strong>Description:</strong> {{ $setting->description ?? '-' }}</p></div>
@endsection
