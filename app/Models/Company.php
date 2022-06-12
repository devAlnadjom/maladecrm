<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner(){
         return $this->hasOne(User::class,"id", 'owner_id');
    }

    public function orders(){
         return $this->hasMany(Order::class);
    }

    public function transactions(){
         return $this->hasMany(Transaction::class);
    }

    public function products(){
         return $this->hasMany(Transaction::class);
    }
    public function customers(){
         return $this->hasMany(Customer::class);
    }

    public function users(){
        return $this->belongsTo(Users::class);
    }
}
