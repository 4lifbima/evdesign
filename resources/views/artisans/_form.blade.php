@php
    $inputCls = 'w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent transition';
    $labelCls = 'block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1';
@endphp

<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="{{ $labelCls }}">Nama Perajin <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $artisan->name ?? '') }}" class="{{ $inputCls }}" required placeholder="Ahmad Batik">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="{{ $labelCls }}">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $artisan->slug ?? '') }}" class="{{ $inputCls }}" placeholder="ahmad-batik">
        </div>
        <div>
            <label class="{{ $labelCls }}">Email</label>
            <input type="email" name="email" value="{{ old('email', $artisan->email ?? '') }}" class="{{ $inputCls }}" placeholder="perajin@email.com">
        </div>
        <div>
            <label class="{{ $labelCls }}">No. Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $artisan->phone ?? '') }}" class="{{ $inputCls }}" placeholder="08xxxxxxxxxx">
        </div>
        <div>
            <label class="{{ $labelCls }}">Kota</label>
            <input type="text" name="city" value="{{ old('city', $artisan->city ?? '') }}" class="{{ $inputCls }}" placeholder="Gorontalo">
        </div>
        <div>
            <label class="{{ $labelCls }}">Provinsi</label>
            <input type="text" name="province" value="{{ old('province', $artisan->province ?? 'Gorontalo') }}" class="{{ $inputCls }}">
        </div>
        <div>
            <label class="{{ $labelCls }}">Status</label>
            <select name="status" class="{{ $inputCls }}">
                <option value="active" @selected(old('status', $artisan->status ?? 'active')==='active')>Active</option>
                <option value="inactive" @selected(old('status', $artisan->status ?? '')==='inactive')>Inactive</option>
                <option value="on_leave" @selected(old('status', $artisan->status ?? '')==='on_leave')>On Leave</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelCls }}">Tanggal Bergabung</label>
            <input type="date" name="joined_date" value="{{ old('joined_date', isset($artisan->joined_date) ? $artisan->joined_date->format('Y-m-d') : '') }}" class="{{ $inputCls }}">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Spesialisasi / Skills (pisah koma)</label>
            <input type="text" name="skills" value="{{ old('skills', isset($artisan) ? implode(', ', $artisan->skills ?? []) : '') }}" class="{{ $inputCls }}" placeholder="Batik, Tenun, Sulam">
        </div>
        <div class="md:col-span-2">
            <label class="{{ $labelCls }}">Bio / Profil Singkat</label>
            <textarea name="bio" rows="4" class="{{ $inputCls }}" placeholder="Ceritakan latar belakang perajin...">{{ old('bio', $artisan->bio ?? '') }}</textarea>
        </div>
    </div>
</div>
