<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Orders/Index',[
            'orders'=> Order::Select()
                    ->where('company_id',auth()->user()->company->id)
                    ->with('customer:id,name')
            ->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$company =auth()->user()->company();
        //$customers =$company->customers();
        return Inertia::render('Orders/Create',[]);
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


        return Redirect::route('orders.index')->with('success', "Order added successfully");
    }


    public function edit(int $id)
    {
        $order = Order::Where('id',$id)
                ->with('products')
                ->get();

        return Inertia::render('Orders/Edit',[
            'order' => $order,
        ]);
    }


    public function update(UpdateOrderRequest $request , int $id)
    {
        $order = Order::findOrFail($id);//('id',$id)->get();

        $validated = $request->safe()->except(['products','id']);

        if ($order->order_key!=$validated['order_key'] || $order->company_id != auth()->user()->company->id){
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

        //if status equal validated then update customer sole, and create new transaction.

        return Redirect::back()->with('success', "Order Updated successfully");
    }




}
