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

    public function imageProduct()
    {
        return $this->hasMany(ImageProduct::class);
    }

    public function categorieProduct()
    {
        return $this->belongsTo(CategorieProduct::class);
    }
}
