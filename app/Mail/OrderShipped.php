<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public function __construct(Order $order)
    {
        $this->order= $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Call a service to create the last version of the invoice then send
        return $this->from('example@example.com', 'Example')
                    ->markdown('emails.orders.shipped',
                        ['url' => '#'])
                    ->attachFromStorage('/public/'.$this->order->order_key.".pdf", 'name.pdf', [
                        'mime' => 'application/pdf'
                    ]);
    }
}
