<?php

namespace App\Services\Dashboard;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardData
{
    public static function customer_count(int $company_id) : Object
    {
       return DB::table('customers')
            ->selectRaw('count(*)  as data')
            ->where('company_id',$company_id)
            ->first();
    }

    public static function invoice_waiting_count(int $company_id) : Object
    {
       return DB::table('orders')
            ->selectRaw('count(*)  as data')
            ->where(['company_id'=>$company_id, 'order_status'=>1])
            ->first();
    }

    /**
     * gives the count and the sum of completed Invoices Of the currents Months
     *
     */
    public static function invoice_completed_count(int $company_id) : Object
    {
       return DB::table('orders')
                ->selectRaw('count(*)  as data_count, sum(ttc_total_order)/100 as data_sum')
                ->where('company_id',$company_id)
                ->whereIn('order_status',[2,3])
                ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE())')
                ->first();
    }

    /**
     * gives the total solde of customers data owes Money to the company
     *
     */
    public static function customers_solde_sum(int $company_id) : Object
    {
       return DB::table('customers')
                    ->selectRaw(' sum(solde)/100 as data')
                    ->where('company_id',$company_id)
                    ->where('active',1)
                    ->where('solde','>',0)
                    ->first();
    }

    /**
     * gives The line product solde sold
     *
     */
    public static function last_product_sold(int $company_id, int $limit =10) : Collection
    {
       return DB::table('order_product')
                ->join('orders', 'orders.id', '=', 'order_product.order_id')
                ->join('customers', 'customers.id', '=', 'orders.customer_id')
                ->select('order_product.*', 'customers.name as nom', 'orders.id', 'orders.order_key')
                ->whereIn('orders.order_status' ,[2,3])
                ->where('orders.company_id' ,$company_id)
                ->orderByDesc('order_product.id')
                ->limit($limit)
                ->get();
    }

    /**
     * Gives The sum of order group by compte Month for the Last 6
     *
     */
    public static function sales_by_month() : Collection
    {
       return Order::select(DB::raw("SUM(ttc_total_order)/100 as somme, MONTH(created_at) as month"))
                //->orderBy('created_at')
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->whereIn('order_status' ,[2,3])
                ->whereBetween('created_at',
                        [Carbon::now()->subMonth(6), Carbon::now()]
                    )
                ->get();
    }
}
