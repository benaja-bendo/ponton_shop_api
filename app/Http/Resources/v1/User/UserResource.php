<?php

namespace App\Http\Resources\v1\User;

use App\Http\Resources\v1\Role\RoleCollection;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "slug" => $this->userInfo->slug ?? null,
            'email' => $this->email ?? null,
            "first_name" => $this->userInfo->first_name ?? null,
            "last_name" => $this->userInfo->last_name ?? null,
            "image_path" => $this->userInfo->image_path ?? null,
            "address" => $this->userInfo->address ?? null,
            "genre" => $this->userInfo->genre ?? null,
            "city" => $this->userInfo->city ?? null,
            "phone" => $this->userInfo->phone ?? null,
            "roles" => new RoleCollection($this->roles),
            "updated_at" => Carbon::parse($this->updated_at)->timestamp ?? null,
            'created_at' => Carbon::parse($this->created_at)->timestamp ?? null,
        ];
    }
}
