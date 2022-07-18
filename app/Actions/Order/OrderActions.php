<?php

namespace App\Actions\Order;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\customerLog;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrderActions
{
    public static function store(StoreOrderRequest $request): Order
    {
        $validated = $request->safe()->except(['products']);
        $products = $request->safe()->only(['products'])['products'] ;

        $validated['total_order']=$validated['total_order']*100;
        $validated['ttc_total_order']=$validated['ttc_total_order']*100;
        $order= Order::create($validated);

        foreach ($products as $product){

            $order->products()->attach($product['product_id'],[
                'name'=> $product['name'],
                'description'=> $product['description'],
                'is_service'=> $product['is_service'],
                'total_price'=> $product['total_price'],
                'tax'=> $product['tax'],
                'total_quantity'=> $product['total_quantity'],
            ]);
        }

        if($validated['order_type']==1){
            $order->update(['order_status'=>3]); //Comptant
            $solde_client=Customer::find($validated['customer_id'])->solde;
            Transaction::create([
                'company_id'=>auth()->user()->company->id,
                'customer_id'=>$validated['customer_id'],
                'user_id'=>auth()->user()->id,
                'description'=>"Ajout de la Facture(Comptant) N:".$order->id." au compte.",
                'debit'=>$validated['ttc_total_order'],
                'credit'=>$validated['ttc_total_order'],
                'solde'=>($solde_client),
            ]);


        }
        (new customerLog)->saveLog("Commande n-".$order->id." Créée",$validated['customer_id']);
        return $order;
    }


    public static function update(UpdateOrderRequest $request, Order $order){

        $company_id = auth()->user()->company->id;
        $validated = $request->safe()->except(['products','id']);

        $validated['total_order']=$validated['total_order']*100;
        $validated['ttc_total_order']=$validated['ttc_total_order']*100;

        if ($order->order_key!=$validated['order_key'] || $order->company_id != $company_id){
            abort(404,"Unable to check this Order.",);
        }

            $order->products()->detach();
            $order->update($validated);
            $products = $request->safe()->only(['products'])['products'] ;

            foreach ($products as $product){
            $order->products()->attach($product['product_id'],[
                'name'=> $product['name'],
                'description'=> $product['description'],
                'is_service'=> $product['is_service'],
                'total_price'=> $product['total_price'],
                'total_quantity'=> $product['total_quantity'],
                'tax'=> $product['tax'],
            ]);
        }

        // Validate
        if($validated['order_status']==2){
            $solde_client=Customer::find($validated['customer_id'])->solde;
            DB::table('customers')->where('id', $validated['customer_id'])->increment('solde',$validated['ttc_total_order']);
            Transaction::create([
                'company_id'=>$company_id,
                'customer_id'=>$validated['customer_id'],
                'user_id'=>auth()->user()->id,
                'description'=>"Ajout Facture N:".$order->id." au compte.",
                'debit'=>"0",
                'credit'=>$validated['ttc_total_order'],
                'solde'=>($validated['ttc_total_order']+ $solde_client),
            ]);

            (new customerLog)->saveLog("Commande n-".$order->id." validée",$validated['customer_id']);
        }

        // Cancel Invoice
        if($validated['order_status']==4){
            $solde_client=Customer::find($validated['customer_id'])->solde;
            DB::table('customers')->where('id', $validated['customer_id'])->decrement('solde',$validated['ttc_total_order']);
            Transaction::create([
                'company_id'=>$company_id,
                'customer_id'=>$validated['customer_id'],
                'user_id'=>auth()->user()->id,
                'description'=>"Annulation Facture N:".$order->id." .",
                'debit'=>$validated['ttc_total_order'],
                'credit'=>"0",
                'solde'=>($solde_client-$validated['ttc_total_order']),
            ]);

            (new customerLog)->saveLog("Commande n-".$order->id." Annulée",$validated['customer_id']);
        }
    }
}
