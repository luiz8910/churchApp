<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class resetPasswordApp extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    public $user;
    public $today;
    public $time;
    public $code;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $url, $today, $time, $code)
    {
        //
        $this->user = $user;
        $this->today = $today;
        $this->time = $time;
        $this->code = $code;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this
                ->from('contato@beconnect.com.br')
                ->subject('Seu código de reenvio de senha')
                ->view('emails.resetPasswordApp');
    }
}
