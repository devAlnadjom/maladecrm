<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\DashboardData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        $user = auth()->user();
        $company_status=true;
        if(!$user->company?->id){
            $company_status= null;

        }else{
                $company_id= auth()->user()->company->id;
                $company_status=$user->company();

                $count_customer = DashboardData::customer_count($company_id);
                $invoice_waiting = DashboardData::invoice_waiting_count($company_id);
                $invoice_completed = DashboardData::invoice_completed_count($company_id);
                $solde = DashboardData::customers_solde_sum($company_id);
                $lastproduct = DashboardData::last_product_sold($company_id);
                $statsale= DashboardData::sales_by_month();

               // dd($count_customer);
            }

        return Inertia::render('Dashboard',[
            'company' => $company_status,
            'customer_count' => isset($count_customer)?$count_customer:0,
            'invoice_waiting' => isset($invoice_waiting)?$invoice_waiting:0,
            'invoice_completed' => isset($invoice_completed)?$invoice_completed:0,
            'solde' => isset($solde)?$solde:0,
            'lastproducts' => isset($lastproduct)?$lastproduct:0,
            'statsale' => isset($statsale)?$statsale:[],
        ]);
    }

    public function adminManagement(){
        abort_if(auth()->id() != 1, 404, 'Unauthorise');
        $users = User::With(['company:id,name'])
            ->paginate(10);
        return Inertia::render('Management/UserList',[
            'users' => $users,
        ]);
    }

    public function adminShow(){
        // abort_if(auth()->id() != 1, 404, 'Unauthorise');
        $users = User::With(['company:id,name'])
            ->paginate(10);

            return Inertia::modal('Management/UserList')
            ->with([
                'user' => ["hello"=>'some'],
            ])
            ->baseRoute('dashboard.userlist',null);
    }
}
