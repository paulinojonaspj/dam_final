<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notificacao extends Mailable
{
    use Queueable, SerializesModels;
    private $assunto;
    private $notificacao;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assunto, $notificacao)
    {
        $this->assunto = $assunto;
        $this->notificacao = $notificacao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notificacao', ["info" => $this->notificacao])
            ->subject($this->assunto);
    }
}
