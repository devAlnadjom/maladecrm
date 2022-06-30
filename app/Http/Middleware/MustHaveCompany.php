<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MustHaveCompany
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if($user->company?->id=== null){
           return Redirect::route("companies.create")->with("error", "Vous devez configurer votre entreprise avant de pouvoir utiliser les autres services.");
        }

        return $next($request);
    }
}
