<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use App\Http\Resources\CategorieProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'small_description' => $this->small_description,
            'long_description' => Str::words($this->long_description, 10),
            'images' => $this->imageProduct,
            'categorie' => $this->categorieProduct,
        ];
    }
}
