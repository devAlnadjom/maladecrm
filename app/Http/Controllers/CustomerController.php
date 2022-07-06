<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{

    public function index()
    {
        return Inertia::render('Customers/Index',[
            'customers'=> Customer::Select(['id','name','contact','solde'])
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
        return Inertia::render('Customers/Create',[]);
    }


    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        $customer=Customer::create($validated);

        return Redirect::route('customers.show',$customer->id)->with('success', "Fiche Client mis à jour");
    }


    public function show( $customer,Request $request)
    {
        $customer= Customer::findOrFail($customer);
       // dd($customer);
       if($request->wantsJson())
       {
        if($request->has('view') && $request->get('view')=="invoices"){
                $invoices=$customer->orders()->get();
                return response()->json($invoices);
            }
       }
        return Inertia::render('Customers/Show',[
            'customers'=> $customer,
        ]);
    }


    public function edit(int $customer, UpdateCustomerRequest $request)
    {
        $customer= Customer::findOrFail($customer);
       // dd($customer);
        return Inertia::render('Customers/Edit',[
            'customers'=> $customer,
        ]);
    }


    public function update(UpdateCustomerRequest $request, $customer)
    {
        $customer= Customer::findOrFail($customer);
        $validated = $request->validated();
        $customer->update($validated);

        return Redirect::back()->with('success', "Fiche Client mis à jour");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
