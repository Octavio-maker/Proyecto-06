<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Resources\ProductoResource;
use App\Http\Requests\StoreProductoRequest;   // ← NUEVO
use App\Http\Requests\UpdateProductoRequest;  // ← NUEVO
use Illuminate\Http\Request;

class ProductoController extends Controller 
{
    public function index(Request $request) 
    {
        $productos = Producto::with('categoria')
            ->buscar($request->busqueda)
            ->deCategoria($request->categoria_id)
            ->rangoPrecio($request->precio_min, $request->precio_max)
            ->orderBy($request->get('orden', 'nombre'), $request->get('dir', 'asc'))
            ->paginate($request->get('por_pagina', 15));

        return ProductoResource::collection($productos);
    }

    public function show($id) 
    {
        $producto = Producto::with('categoria')->find($id);
        
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return new ProductoResource($producto);
    }

    // ↓ Cambia Request por StoreProductoRequest
    public function store(StoreProductoRequest $request) 
    {
        // Ya NO necesitas $this->authorize() aquí, el Form Request lo hace
        // Ya NO necesitas $request->validate() aquí, el Form Request lo hace

        $data = $request->validated(); // ← solo los campos validados

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);
        return response()->json(['message' => 'Producto creado con éxito', 'data' => $producto], 201);
    }

    // ↓ Cambia Request por UpdateProductoRequest
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);
        return new ProductoResource($producto);
    }

    public function destroy(Producto $producto) 
    {
        $this->authorize('delete', $producto);
        $producto->delete();
        return response()->noContent();
    }
}