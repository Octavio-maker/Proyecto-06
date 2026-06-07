<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'nombre'      => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio'      => $this->precio,
            'imagen'      => $this->imagen,
            'categoria'   => new CategoriaResource(
                                $this->whenLoaded('categoria')
                             ),
        ];
    }
}