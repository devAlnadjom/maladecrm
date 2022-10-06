<?php

namespace App\Http\Controllers;

use App\Actions\Invoice\InvoiceActions;
use App\Actions\Order\OrderActions;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Jobs\SendEmailJob;
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
        $orders =  Order::Select()
        ->where('order_status','<>','6')
        ->latest()
        ->with('customer:id,name')
        ->paginate(10);
       /* ->withQueryString()
        ->map(function ($item, $key) {
            $item->ttc_total_order= $item->ttc_total_order/100;
            $item->total_order= $item->total_order/100;
            return $item;
        });*/
       // dd($orders);
        return Inertia::render('Orders/Index',[
            'orders'=> $orders
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

        $order= OrderActions::store($request);

        return Redirect::route('orders.edit',$order->id)->with('success', "Facture créée");
    }


    public function edit($id)
    {

        $order = Order::Where('id',$id)
                ->with('products')
                ->get();

        $customers= Customer::Select(['id','name','contact','solde'])
                    ->get();


        return Inertia::render('Orders/Edit',[
            'order' => $order,
            'customers'=> $customers,
            'company'=> auth()->user()->company->name,
        ]);
    }


    public function update(UpdateOrderRequest $request , int $id)
    {
        $order = Order::findOrFail($id);
        OrderActions::update($request,$order);

        return Redirect::back()->with('success', "Facture mis a jour.");
    }



    public function destroy(int $order_id)
    {
        $order = Order::findOrFail($order_id);

        if ($order->order_status != '1'){
            return Redirect::back()->with('error', "Cette Facture ne peut plus etre suprrimée.");
        }

        $order->update(['order_status' => '6']); //Deleted
        return Redirect::route('orders.index')->with('success', "Facture supprimée..");
    }

    public function cloneOrder( int $order_id)
    {
        $order_to_clone = Order::findOrFail($order_id);
        $order= OrderActions::clone($order_to_clone);

        return Redirect::route('orders.edit',$order->id)->with('success', "Facture clonée.");
    }


    public function sendMailtoCustomer( Request $request, int $order_id)
    {
        $order = Order::findOrFail($order_id);

        $validated = $request->validate([
            'customer_id' => 'numeric|required',
            'order_key'=> 'string|required',
            'subject'=> "string|required|max:50",
            'message'=> "string|required|max:300",
        ]);

        abort_if(( $order->order_key != $validated['order_key']) , '403');

        $email = $order->customer->email;
        $data =[
            "from" => auth()->user()->company->name,
            "subject" => $validated['subject'],
            "message" => $validated['message'],
            "order_key" => $order->order_key,
            "link" => route('invoices', array($order->order_key, $order_id)),
            "email" => $email,
        ];

        try{
            $invoice = InvoiceActions::buildInvoice($order_id);
        }catch(\Exception $e){
            abort(404,"Factue Introuvable!");
        }

        $data = collect($data);
        if($invoice){
            dispatch(new SendEmailJob($data))->afterResponse();
        }

        return Redirect::route('orders.edit',$order->id)->with('success', "Message envoyé.");
    }

}
