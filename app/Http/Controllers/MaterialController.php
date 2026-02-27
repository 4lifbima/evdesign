<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use App\Models\MaterialStockHistory;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::when(request('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(StoreMaterialRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']).'-'.Str::lower(Str::random(4));
        $data['is_active'] = $request->boolean('is_active');
        $stock = (int) ($data['stock'] ?? 0);

        $material = Material::create($data);

        if ($stock > 0) {
            MaterialStockHistory::create([
                'material_id' => $material->id,
                'type' => 'in',
                'quantity' => $stock,
                'stock_before' => 0,
                'stock_after' => $stock,
                'notes' => 'Stok awal material',
                'created_by' => $request->user()?->id,
            ]);
        }

        return redirect()->route('materials.index')->with('success', 'Material berhasil ditambahkan.');
    }

    public function show(Material $material)
    {
        $material->load('stockHistories');

        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']).'-'.$material->id;
        $data['is_active'] = $request->boolean('is_active');

        $oldStock = $material->stock;
        $newStock = (int) ($data['stock'] ?? $oldStock);

        $material->update($data);

        if ($oldStock !== $newStock) {
            MaterialStockHistory::create([
                'material_id' => $material->id,
                'type' => 'adjustment',
                'quantity' => abs($newStock - $oldStock),
                'stock_before' => $oldStock,
                'stock_after' => $newStock,
                'notes' => 'Penyesuaian stok dari halaman edit material',
                'created_by' => $request->user()?->id,
            ]);
        }

        return redirect()->route('materials.index')->with('success', 'Material berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material berhasil dihapus.');
    }
}
