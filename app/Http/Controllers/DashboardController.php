<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();
        $company_status=true;
        if(!$user->company?->id){
            $company_status= null;
            //abort(404);
        }else{
                $company_status=$user->company();
            }

        return Inertia::render('Dashboard',[
            'company' => $company_status,
        ]);
    }
}
