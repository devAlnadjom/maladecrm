<?php

namespace App\Models;

use App\Traits\FilterByCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory, FilterByCompany;

    protected $guarded = [];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function task(){
        return  $this->belongsTo(Task::class);
    }
}
