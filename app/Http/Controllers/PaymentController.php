<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\customerLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {

        $payments=Payment::Select(['id','description','montant','date','method','customer_id'])
                            ->latest()
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
        $validated['montant']=$validated['montant']*100;
        $payment=Payment::create($validated);
        $company_id =auth()->user()->company->id;


            $solde_client=Customer::find($validated['customer_id'])->solde;
            DB::table('customers')->where('id', $validated['customer_id'])->decrement('solde',$validated['montant']);
            Transaction::create([
                'company_id'=>$company_id,
                'customer_id'=>$validated['customer_id'],
                'user_id'=>auth()->user()->id,
                'description'=>"Paiemnt dans le compte.",
                'debit'=>$validated['montant'],
                'credit'=>"0",
                'solde'=>$solde_client-$validated['montant'],
            ]);

            (new customerLog)->saveLog("Reglemnt de ".$validated['montant'].", Ref:".$payment->id." .",$validated['customer_id']);
        return Redirect::route('payments.index')->with('success', "Paiement ajouté au compte du client");
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
