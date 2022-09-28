<?php

namespace App\Models;

use App\Models\CategorieProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ImageProduct;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function imageProduct(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ImageProduct::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(CategorieProduct::class, 'categorie_has_product', 'product_id', 'categorie_product_id');
    }
}
