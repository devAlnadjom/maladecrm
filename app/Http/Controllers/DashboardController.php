<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $company_id= auth()->user()->company->id;
                $company_status=$user->company();
                $count_customer = DB::table('customers')
                                ->selectRaw('count(*)  as data')
                                ->where('company_id',$company_id)
                                ->first();

                $invoice_waiting = DB::table('orders')
                                ->selectRaw('count(*)  as data')
                                ->where(['company_id'=>$company_id, 'order_status'=>1])
                                ->first();

                $invoice_completed = DB::table('orders')
                                ->selectRaw('count(*)  as data_count, sum(ttc_total_order) as data_sum')
                                ->where('company_id',$company_id)
                                ->whereIn('order_status',[2,3])
                                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE())')
                                ->first();
                $solde = DB::table('customers')
                                ->selectRaw(' sum(solde) as data')
                                ->where('company_id',$company_id)
                                ->where('active',1)
                                ->first();


                $lastproduct = DB::table('order_product')
                                ->join('orders', 'orders.id', '=', 'order_product.order_id')
                                ->join('customers', 'customers.id', '=', 'orders.customer_id')
                                ->select('order_product.*', 'customers.name as nom', 'orders.id', 'orders.order_key')
                                ->whereIn('orders.order_status' ,[2,3])
                                ->where('orders.company_id' ,$company_id)
                                ->orderByDesc('order_product.id')
                                ->limit(10)
                                ->get();


                //ddd($lastproduct);
            }

        return Inertia::render('Dashboard',[
            'company' => $company_status,
            'customer_count' => isset($count_customer)?$count_customer:0,
            'invoice_waiting' => isset($invoice_waiting)?$invoice_waiting:0,
            'invoice_completed' => isset($invoice_completed)?$invoice_completed:0,
            'solde' => isset($solde)?$solde:0,
            'lastproducts' => isset($lastproduct)?$lastproduct:0,
        ]);
    }
}
