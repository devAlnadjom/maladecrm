<?php

namespace App\Mail;

//use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public function __construct( $order)
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
        return $this->from('mystere@devalnadjom.com', $this->order->get('from'))
                    ->subject($this->order->get('subject'))
                    ->markdown('emails.orders.shipped',
                        ['url' =>$this->order->get('link'), 'message' => $this->order->get('message')])
                    ->attachFromStorage('/public/'.$this->order->get('order_key').".pdf", 'name.pdf', [
                        'mime' => 'application/pdf'
                    ]);
    }
}
