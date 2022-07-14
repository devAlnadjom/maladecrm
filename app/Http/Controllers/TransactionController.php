<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function customer_portal( int $customer_id, $public_key=null)
    {
        $customer = Customer::withoutGlobalScopes()->findOrFail($customer_id);
        $company = Company::withoutGlobalScopes()->findOrFail($customer->company_id);

        abort_if($public_key!=sha1($customer->id.'00'.$company->id),'404');

        $transactions = Transaction::Where('customer_id', $customer_id)
                        ->latest()
                        ->get();



        return view('transactions_portal', [
            'transactions' => $transactions,
            'customer' => $customer,
            'company' => $company
        ]);
    }
}
