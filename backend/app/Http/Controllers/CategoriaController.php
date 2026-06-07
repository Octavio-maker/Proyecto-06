<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        return CategoriaResource::collection(
            Categoria::with('productos')->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = Categoria::create([
            'nombre'      => $request->nombre,
            'slug'        => Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
        ]);

        return new CategoriaResource($categoria);
    }

    public function show(Categoria $categoria)
    {
        return new CategoriaResource(
            $categoria->load('productos')
        );
    }

    public function update(Request $request, Categoria $categoria)
    {
        $categoria->update($request->all());
        return new CategoriaResource($categoria);
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return response()->json(null, 204);
    }

    public function productos(Categoria $categoria)
    {
        return ProductoResource::collection(
            $categoria->productos()->with('categoria')->get()
        );
    }
}