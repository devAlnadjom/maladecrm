<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;


class InvoiceController extends Controller
{

    public function __invoke(Request $request,  $order_key,$order_id)
    {

        $order= Order::withoutGlobalScopes()->findOrFail($order_id);

        if($order->order_key != $order_key)
            abort(404);

        $client= $order->customer()->withoutGlobalScopes()->first();
        $products= $order->products()->withoutGlobalScopes()->get();
        $company = $order->company()->withoutGlobalScopes()->first();

        $items=[];

        foreach($products as $product){
            $items[] = (new InvoiceItem())
            ->title($product->pivot->name)
            ->taxByPercent($product->pivot->tax)
            //->description('Your product or service description')
            ->pricePerUnit($product->pivot->total_price)
            ->quantity($product->pivot->total_quantity);
            //->discount(10);
        }
        if(!count($items)){
            abort(404);
        }
        //dd($items);
        $status="Drawn";
        switch($order->order_status){
            case 1:
                $status="Created";
                break;
            case 2:
                $status="Validated";
                break;
            case 3:
                $status="Paid";
                break;
            case 4:
                $status="Cancelled";
                break;
        }

        $currency_sign="CFA";
        $currency_code="XAF";

        $customer = new Party([
            'name'          => $client->name,
            'phone'         => $client->contact,
            'custom_fields' => [
                'note'        => $order->ref_customer,
                //'business id' => '365#GG',
            ],
        ]);

        $clientt = new Party([
            'name'          => $company->name,
            'address'       => $company->address,
            //'code'          => '#22663214',
            'custom_fields' => [
                'order number' => 'Fact-'.$client->id."-".$order->id,
            ],
        ]);



        $notes = [
            'Thanks for ordering from us.'
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Invoice')
            ->series('FACT')
            // ability to include translated invoice status
            // in case it was paid
           // ->status(__('invoices::invoice.drawn'))
            ->status($status)
            ->sequence($order->id)
            ->serialNumberFormat('{SERIES}-'.$client->id.'-{SEQUENCE}')
            ->seller($clientt)
            ->buyer($customer)
            ->date(Carbon::parse($order->date_order))
            ->dateFormat('d/m/Y')
            ->payUntilDays(30)
            ->currencySymbol($currency_sign)
            ->currencyCode($currency_code)
            ->currencyFormat('{VALUE} {SYMBOL}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($order->order_key)
            ->addItems($items)
            ->notes($notes)
           // ->taxRate($order->tax_1_percentage)
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
        //return $invoice->toHtml();
    }
}
