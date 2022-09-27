<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductRessource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategorieProductRessource;

class CategorieProductResource extends JsonResource
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
            'status' => $this->status,
            'subCategorieProduct' => SubCategorieProductResource::collection($this->subCategorieProducts),
            // 'products' => new ProductRessource($this->product)
        ];
    }
}
