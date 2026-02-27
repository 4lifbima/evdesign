<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtisanRequest;
use App\Http\Requests\UpdateArtisanRequest;
use App\Models\Artisan;
use Illuminate\Support\Str;

class ArtisanController extends Controller
{
    public function index()
    {
        $artisans = Artisan::when(request('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('artisans.index', compact('artisans'));
    }

    public function create()
    {
        return view('artisans.create');
    }

    public function store(StoreArtisanRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']).'-'.Str::lower(Str::random(4));
        $data['skills'] = $this->csvToArray($data['skills'] ?? null);

        Artisan::create($data);

        return redirect()->route('artisans.index')->with('success', 'Perajin berhasil ditambahkan.');
    }

    public function show(Artisan $artisan)
    {
        $artisan->load('products');

        return view('artisans.show', compact('artisan'));
    }

    public function edit(Artisan $artisan)
    {
        return view('artisans.edit', compact('artisan'));
    }

    public function update(UpdateArtisanRequest $request, Artisan $artisan)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']).'-'.$artisan->id;
        $data['skills'] = $this->csvToArray($data['skills'] ?? null);

        $artisan->update($data);

        return redirect()->route('artisans.index')->with('success', 'Perajin berhasil diperbarui.');
    }

    public function destroy(Artisan $artisan)
    {
        $artisan->delete();

        return redirect()->route('artisans.index')->with('success', 'Perajin berhasil dihapus.');
    }

    private function csvToArray(?string $value): ?array
    {
        if (! $value) {
            return null;
        }

        return collect(explode(',', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
