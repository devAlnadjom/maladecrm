<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
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


    /*public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        Customer::create($validated);

        return Redirect::route('customers.index')->with('success', "Customer added successfully");
    }*/


}
