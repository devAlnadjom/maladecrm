<?php

namespace App\Models;

use App\Traits\FilterByCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, FilterByCompany;
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
