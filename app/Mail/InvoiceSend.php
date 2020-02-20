<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceSend extends Mailable
{
    use Queueable, SerializesModels;

    public $numsale;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Numsale $numsale)
    {
        $this->numsale=$numsale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.InvoiceSend');
    }
}
