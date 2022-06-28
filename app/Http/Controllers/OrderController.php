<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Mail\OrderShipped;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Orders/Index',[
            'orders'=> Order::Select()
                    ->where('order_status','<>','6')
                    ->with('customer:id,name')
            ->paginate(10),
        ]);
    }


    public function create(Request $request)
    {
        if ($request->has('customer_id')) {
            $customer_id=$request->query('customer_id');
        }
        $customers= Customer::Select(['id','name','contact','solde'])
                    ->get();
            //dd($customers);
        return Inertia::render('Orders/Create',[
            'customers'=> $customers,
            'company'=> auth()->user()->company->name,
            'customer_id' => isset($customer_id)?$customer_id:null
        ]);
    }


    public function store(StoreOrderRequest $request)
    {
        $validated = $request->safe()->except(['products']);
        $products = $request->safe()->only(['products'])['products'] ;
        $order= Order::create($validated);

        //dd($products);
        foreach ($products as $product){

            $order->products()->attach($product['product_id'],[
                'name'=> $product['name'],
                'description'=> $product['description'],
                'is_service'=> $product['is_service'],
                'total_price'=> $product['total_price'],
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
                'description'=>"Adding Facture(Comptant) N:".$order->id." to account.",
                'debit'=>100*$validated['ttc_total_order'],
                'credit'=>100*$validated['ttc_total_order'],
                'solde'=>100*($solde_client),
            ]);


        }


        return Redirect::route('orders.edit',$order->id)->with('success', "Order added successfully");
    }


    public function edit($id)
    {
        //Mail::to('altest@gmail.com')->send(new OrderShipped( Order::findOrFail($id)));
        $order = Order::Where('id',$id)
                ->with('products')
                ->get();

    $customers= Customer::Select(['id','name','contact','solde'])
                ->where('company_id',auth()->user()->company->id)
                ->get();


        return Inertia::render('Orders/Edit',[
            'order' => $order,
            'customers'=> $customers,
            'company'=> auth()->user()->company->name,
        ]);
    }


    public function update(UpdateOrderRequest $request , int $id)
    {
        $order = Order::findOrFail($id);//('id',$id)->get();
        $company_id = auth()->user()->company->id;
        $validated = $request->safe()->except(['products','id']);

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
                'description'=>"Adding Facture N:".$order->id." to account.",
                'debit'=>"0",
                'credit'=>100*$validated['ttc_total_order'],
                'solde'=>100*($validated['ttc_total_order']+ $solde_client),
            ]);

            return Redirect::route('orders.index')->with('success', "Order Updated successfully");
        }

        // Cancel Invoice
        if($validated['order_status']==4){
            $solde_client=Customer::find($validated['customer_id'])->solde;
            DB::table('customers')->where('id', $validated['customer_id'])->decrement('solde',$validated['ttc_total_order']);
            Transaction::create([
                'company_id'=>$company_id,
                'customer_id'=>$validated['customer_id'],
                'user_id'=>auth()->user()->id,
                'description'=>"Cancelling Facture N:".$order->id." to account.",
                'debit'=>100*$validated['ttc_total_order'],
                'credit'=>"0",
                'solde'=>100*($solde_client-$validated['ttc_total_order']),
            ]);

            return Redirect::route('orders.index')->with('success', "Facture Mis a Jour");
        }


        return Redirect::back()->with('success', "Facture mis a jour.");
    }



    public function destroy(int $order_id)
    {
        $order = Order::findOrFail($order_id);

        if ($order->order_status != '1'){
            return Redirect::back()->with('success', "Cette Facture ne peut plus etre suprrimer.");
        }
        $order->update(['order_status' => '6']); //Deleted
        return Redirect::route('orders.index')->with('success', "Facture supprimee..");
    }



}
