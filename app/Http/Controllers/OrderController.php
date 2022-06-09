<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
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
        return Inertia::render('Orders/Create',[]);
    }


    public function store(StoreOrderRequest $request)
    {
        $validated = $request->safe()->except(['products']);;
        //dd($validated);
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
               // 'ligne_total'=>$product['ligne_total']
            ]);
        }


        return Redirect::route('orders.index')->with('success', "Order added successfully");
    }


}
