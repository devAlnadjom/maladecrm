<?php

namespace App\Actions\Invoice;

use App\Models\Order;
use Illuminate\Support\Carbon;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceActions
{
    public static function buildInvoice($order_id) :Invoice
    {
        $order= Order::withoutGlobalScopes()->findOrFail($order_id);

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
            throw new \Exception('No Lines');
        }

        $status="Brouillon";

        $status= getInvoiceStatus($order->order_status);

        $currency_sign="CFA";
        $currency_code="XAF";

        $customer = new Party([
            'name'          => $client->name,
            'phone'         => $client->contact,
            'custom_fields' => [
                'Ref'        => $order->ref_customer,
            ],
        ]);

        $clientt = new Party([
            'name'          => $company->name,
            'address'       => $company->address,
            //'code'          => '#22663214',
            'custom_fields' => [
                'Reference' => 'Fact-'.$client->id."-".$order->id,
            ],
        ]);



        $notes = [
            'Merci de nous faire confiance.'
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

        //$link = $invoice->url();
        // Then send email to party with link
        return $invoice;
    }




}

function getInvoiceStatus($status): string
{
    switch($status){
        case 1:
            $status="Créée";
            break;
        case 2:
            $status="Validée";
            break;
        case 3:
            $status="Payée";
            break;
        case 4:
            $status="Annulée";
            break;
    }
    return $status;

}
