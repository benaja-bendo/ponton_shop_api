<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'categorie_has_product', 'categorie_product_id', 'product_id');
    }

}
