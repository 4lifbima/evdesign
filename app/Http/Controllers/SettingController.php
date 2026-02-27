<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::when(request('q'), fn ($q, $term) => $q->where('key', 'like', "%{$term}%"))
            ->orderBy('group')
            ->orderBy('key')
            ->paginate(20)
            ->withQueryString();

        return view('settings.index', compact('settings'));
    }

    public function create()
    {
        return view('settings.create');
    }

    public function store(StoreSettingRequest $request)
    {
        Setting::create($request->validated());

        return redirect()->route('settings.index')->with('success', 'Setting berhasil ditambahkan.');
    }

    public function show(Setting $setting)
    {
        return view('settings.show', compact('setting'));
    }

    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update($request->validated());

        return redirect()->route('settings.index')->with('success', 'Setting berhasil diperbarui.');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'Setting berhasil dihapus.');
    }
}
