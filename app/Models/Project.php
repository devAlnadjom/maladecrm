<?php

namespace App\Models;

use App\Traits\FilterByCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, FilterByCompany;
    protected $guarded = [];


    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }


}
