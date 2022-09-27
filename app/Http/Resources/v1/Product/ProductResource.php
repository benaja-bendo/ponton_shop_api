<?php

namespace App\Http\Resources\v1\Product;

use App\Http\Resources\v1\ImageProduct\ImageProductCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'small_description' => $this->small_description,
            'long_description' => $this->long_description,
            'price' => $this->price,
            'disponible' => $this->disponible,
            'status' => $this->status,
            'images' => new ImageProductCollection($this->imageProduct),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
