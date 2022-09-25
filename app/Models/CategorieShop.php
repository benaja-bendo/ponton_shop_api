<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieShop extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
