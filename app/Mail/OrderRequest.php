<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class OrderRequest
 *
 * @package App\Mail
 */
class OrderRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\Order
     */
    public $order;

    /**
     * OrderRequest constructor.
     *
     * @param \App\Models\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Order Request #' . $this->order->id)->from('no_reply@' . env('DOMAIN_NAME'))->view('emails.order_request');
    }
}
