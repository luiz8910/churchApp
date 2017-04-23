<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class resetPassword extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    public $user;
    /**
     * @var
     */
    public $url;
    /**
     * @var
     */
    public $today;
    /**
     * @var
     */
    public $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $url, $today, $time)
    {
        $this->user = $user;
        $this->url = $url;
        $this->today = $today;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('contato@beconnect.com.br')
            ->subject('Recuperação de Senha')
            ->view("emails.resetEmail");
    }
}
