@php
    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Nama Tag <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $tag->name ?? '') }}" class="{{ $inputCls }}" required placeholder="Batik Tulis">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $tag->slug ?? '') }}" class="{{ $inputCls }}" placeholder="batik-tulis">
        </div>
    </div>
</div>

<script>
document.querySelector('[name="name"]')?.addEventListener('input', function() {
    const slugInput = document.querySelector('[name="slug"]');
    if (slugInput && !slugInput.value) {
        slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim();
    }
});
</script>
