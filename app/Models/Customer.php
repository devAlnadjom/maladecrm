<?php

namespace App\Models;

use App\Traits\FilterByCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, FilterByCompany;

    protected $guarded = [];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function customerLogs(){
        return $this->hasMany(customerLog::class);
    }

}
