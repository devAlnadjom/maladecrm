<?php

namespace App\Models;

use App\Traits\FilterByCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class customerLog extends Model
{
    use HasFactory, FilterByCompany;
    protected $guarded = [];
    protected $casts = [
        'created_at'  => 'date:Y-m-d H:m',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }



    public function saveLog(String $comment, $customer_id=NULL){
        $this->create([
            'type' => 'LOG',
            'comment' => $comment,
            'user_id'=> auth()->id(),
            'company_id'=>auth()->user()->company_id,
            'customer_id' => $customer_id,
        ]);
    }

}
