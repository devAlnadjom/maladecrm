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
                                    ->where('company_id',auth()->user()->company->id)
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
        Customer::create($validated);

        return Redirect::route('customers.index')->with('success', "Customer added successfully");
    }


    public function show( $customer)
    {
        $customer= Customer::findOrFail($customer);
       // dd($customer);
        return Inertia::render('Customers/Edit',[
            'customers'=> $customer,
        ]);
    }


    public function edit(int $customer, UpdateCustomerRequest $request)
    {
        $customer= Customer::findOrFail($customer);
        $validated = $request->validated();
        //dd($validated);
        $customer->update($validated);

        return Redirect::back()->with('success', "Customer added successfully");
    }


    public function update(UpdateCustomerRequest $request, $customer)
    {
        $customer= Customer::findOrFail($customer);
        $validated = $request->validated();
        //dd($validated);
        $customer->update($validated);

        return Redirect::back()->with('success', "Customer added successfully");
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
