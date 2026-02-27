@extends('layouts.dashboard')
@section('title', 'Edit Artikel')
@section('content')
<form action="{{ route('articles.update',$article) }}" method="POST" class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-4">@csrf @method('PUT') @include('articles._form')<div class="flex gap-2"><button class="px-4 py-2 bg-red-600 text-white rounded-xl">Update</button><a href="{{ route('articles.index') }}" class="px-4 py-2 border rounded-xl">Batal</a></div></form>
@endsection
