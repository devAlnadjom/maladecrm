<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Orders(){
        return $this->belongsToMany(Product::class)
            ->withPivot("name","description","is_service","total_price","total_quantity");
    }
}
