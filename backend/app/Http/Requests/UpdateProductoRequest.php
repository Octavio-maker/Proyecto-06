<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('producto'));
    }

    public function rules(): array
    {
        return [
            'nombre'       => 'sometimes|string|min:3|max:100',
            'descripcion'  => 'nullable|string|max:500',
            'precio'       => 'sometimes|numeric|min:0.01|max:99999',
            'stock'        => 'sometimes|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen'       => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.min'          => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max'          => 'El nombre no puede superar :max caracteres.',
            'precio.numeric'      => 'El precio debe ser un número.',
            'precio.min'          => 'El precio debe ser mayor a cero.',
            'stock.integer'       => 'El stock debe ser un número entero.',
            'stock.min'           => 'El stock no puede ser negativo.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'imagen.mimes'        => 'La imagen debe ser JPG, PNG o WEBP.',
            'imagen.max'          => 'La imagen no puede superar 2 MB.',
        ];
    }
}