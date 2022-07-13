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

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    public function __construct($id)
    {
        $this->id =$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $order=  Order::withoutGlobalScopes()->findOrFail($this->id);
            InvoiceActions::buildInvoice($order->id);
            Mail::to('altest@gmail.com')->send(new OrderShipped($order));
    }
}
