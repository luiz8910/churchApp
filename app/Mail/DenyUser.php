<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DenyUser extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $user;
    /**
     * @var
     */
    public $msg;
    /**
     * @var
     */
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $msg, $url)
    {
        $this->user = $user;
        $this->msg = $msg;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Seu Cadastro está quase pronto';

        return $this
                ->from('admin@beconnect.com.br')
                ->subject($subject)
                ->view('emails.denyUser');
    }
}
