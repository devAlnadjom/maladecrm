<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function customer_portal( int $customer_id)
    {
        $transactions = Transaction::Where('customer_id', $customer_id)
                        ->latest()
                        ->get();

       // dd($transactions);

        return view('transactions_portal', ['transactions' => $transactions]);
    }
}
