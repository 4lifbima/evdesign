<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div><label class="block mb-1">Key</label><input type="text" name="key" value="{{ old('key', $setting->key ?? '') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800" required></div>
<div><label class="block mb-1">Group</label><input type="text" name="group" value="{{ old('group', $setting->group ?? 'general') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div><label class="block mb-1">Type</label><input type="text" name="type" value="{{ old('type', $setting->type ?? 'text') }}" class="w-full rounded-xl border-slate-300 dark:bg-slate-800"></div>
<div class="md:col-span-2"><label class="block mb-1">Value</label><textarea name="value" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">{{ old('value', $setting->value ?? '') }}</textarea></div>
<div class="md:col-span-2"><label class="block mb-1">Description</label><textarea name="description" class="w-full rounded-xl border-slate-300 dark:bg-slate-800">{{ old('description', $setting->description ?? '') }}</textarea></div>
</div>
