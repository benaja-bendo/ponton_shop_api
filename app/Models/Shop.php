<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\CategorieShop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categorieShop()
    {
        return $this->belognsTo(CategorieShop::class);
    }
}
