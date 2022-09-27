<?php

namespace App\Http\Resources\v1\ImageProduct;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageProductResource extends JsonResource
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
            'path' => url($this->path),
        ];
    }
}
