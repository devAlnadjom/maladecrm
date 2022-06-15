<?php

namespace App\Models;

use App\Traits\FilterByCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory, FilterByCompany;
    protected $guarded = [];



    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)
            ->withPivot("name","description","is_service","total_price","total_quantity");
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
