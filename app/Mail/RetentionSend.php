<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetentionSend extends Mailable
{
    use Queueable, SerializesModels;

    public $detailret;

    public $retentionsend;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Detailret $detailret)
    {
        $this->detailret = $detailret;
        // $this->retentionsend = $retentionsend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.retention_send');
        // ->attachData($this->pdf, 'retention.pdf', ['mime' => 'application/pdf']);
    }
}
