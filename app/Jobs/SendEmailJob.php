<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Actions\Invoice\InvoiceActions;


use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   // protected $id;
    public  $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
           /* $order=  Order::withoutGlobalScopes()->findOrFail($this->id);
            InvoiceActions::buildInvoice($order->id);*/
            //$data= json_decode($this->data);
            Log::info("merci:" . print_r($this->data->get('email'), true));
            //return;
            Mail::to($this->data->get('email'))->send(new OrderShipped($this->data));
    }
}
