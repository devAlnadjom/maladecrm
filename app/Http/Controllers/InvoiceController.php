<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use App\Actions\Invoice\InvoiceActions;

class InvoiceController extends Controller
{

    public function __invoke(Request $request,  $order_key,$order_id)
    {

        $order= Order::withoutGlobalScopes()->findOrFail($order_id);

        if($order->order_key != $order_key)
            abort(404);
        try{
            $invoice = InvoiceActions::buildInvoice($order_id);
        }catch(\Exception $e){
            abort(404,"Factue Introuvable!");
        }

        return $invoice->stream();
    }
}
