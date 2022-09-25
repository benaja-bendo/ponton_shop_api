<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subCategorieProducts()
    {
        return $this->hasMany(SubCategorieProduct::class);
    }
}
