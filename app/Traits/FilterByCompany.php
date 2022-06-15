<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByCompany{
    public static function boot(){
        parent::boot();

        /*self::creating(function($model){
            $model->user_id= auth()->user()->id;
        });*/

        self::addGlobalScope(function(Builder $builder){
            $builder->where('company_id', auth()->user()->company->id);
        });
    }
}
