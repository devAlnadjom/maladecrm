<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {

        $payments=Payment::Select(['id','description','montant','date','method','customer_id'])

                            ->with('customer:id,name')
                            ->paginate(10);



        return Inertia::render('Payments/Index',[
            'payments'=> $payments,
        ]);
    }


    public function create( Request $request)
    {
        if ($request->has('customer_id')) {
            $customer_id=$request->query('customer_id');
        }

        $customers= Customer::Select(['id','name','contact','solde'])
                    //->where('company_id',auth()->user()->company->id)
                    ->get();
        return Inertia::render('Payments/Create',[
            'customers'=> $customers,
            'customer_id' => isset($customer_id)?$customer_id:null
        ]);
    }


    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        $payment=Payment::create($validated);
        $company_id =auth()->user()->company->id;

            $solde_client=Customer::find($validated['customer_id'])->solde;
            DB::table('customers')->where('id', $validated['customer_id'])->decrement('solde',$validated['montant']);
            Transaction::create([
                'company_id'=>$company_id,
                'customer_id'=>$validated['customer_id'],
                'user_id'=>auth()->user()->id,
                'description'=>"Paiemnt dans le compte to account.",
                'debit'=>100*$validated['montant'],
                'credit'=>"0",
                'solde'=>100*($solde_client-$validated['montant']),
            ]);


        return Redirect::route('payments.index')->with('success', "Payment added successfully");
    }


    public function show( $customer)
    {
        $payment= Payment::findOrFail($customer);
       // dd($customer);
        return Inertia::render('Payments/Edit',[
            'payment'=> $payment,
        ]);
    }
}
