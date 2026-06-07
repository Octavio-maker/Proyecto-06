<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller 
{
    public function index() {
    $productos = Producto::all()->map(function($prod) {
        $prod->imagen_url = $prod->imagen ? asset('storage/' . $prod->imagen) : asset('storage/default.jpg');
        return $prod;
    });

    return response()->json($productos);
}

    public function show($id) 
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Aseguramos que la imagen tenga URL pública
        $producto->imagen_url = $producto->imagen ? asset('storage/' . $producto->imagen) : null;
        
        // Retornamos el objeto dentro de una llave 'data' para consistencia
        return response()->json(['data' => $producto]);
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