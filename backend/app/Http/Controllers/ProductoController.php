<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Resources\ProductoResource; // Asegúrate de tener este Resource
use Illuminate\Http\Request;

class ProductoController extends Controller 
{
    public function index(Request $request) 
    {
        // Usamos los Query Scopes implementados en el modelo 
        $productos = Producto::with('categoria')
            ->buscar($request->busqueda)
            ->deCategoria($request->categoria_id)
            ->rangoPrecio($request->precio_min, $request->precio_max)
            ->orderBy($request->get('orden', 'nombre'), $request->get('dir', 'asc'))
            ->paginate($request->get('por_pagina', 15)); // 15 items por página [cite: 46]

        // Retornamos la colección paginada 
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

    public function store(Request $request) 
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);
        return response()->json(['message' => 'Producto creado con éxito', 'data' => $producto], 201);
    }
}