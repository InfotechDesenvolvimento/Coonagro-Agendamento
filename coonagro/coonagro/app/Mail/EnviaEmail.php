<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviaEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $agendamento;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agendamento)
    {
        $this->agendamento = $agendamento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Agendamento finalizado!')
                    ->view('email');
    }
}
