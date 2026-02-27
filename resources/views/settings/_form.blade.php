@php
    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Key <span class="text-red-500">*</span></label>
            <input type="text" name="key" value="{{ old('key', $setting->key ?? '') }}" class="{{ $inputCls }}" required placeholder="site_name">
            @error('key') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Group</label>
            <input type="text" name="group" value="{{ old('group', $setting->group ?? 'general') }}" class="{{ $inputCls }}" placeholder="general, seo, social">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Type</label>
            <select name="type" class="{{ $inputCls }}">
                @foreach(['text', 'textarea', 'image', 'boolean', 'number', 'color', 'file'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $setting->type ?? 'text')===$type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Value</label>
            <textarea name="value" rows="3" class="{{ $inputCls }}" placeholder="Nilai dari konfigurasi ini...">{{ old('value', $setting->value ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Deskripsi</label>
            <textarea name="description" rows="2" class="{{ $inputCls }}" placeholder="Keterangan tentang pengaturan ini...">{{ old('description', $setting->description ?? '') }}</textarea>
        </div>
    </div>
</div>
