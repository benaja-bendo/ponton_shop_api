<?php

namespace App\Models;

use App\Models\Product;
use App\Models\CategorieProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategorieProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categorieProduct()
    {
        return $this->belongsTo(CategorieProduct::class);
    }
}
