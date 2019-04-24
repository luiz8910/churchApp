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
     * @var null
     */
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $url, $today, $time, $password = null)
    {
        $this->user = $user;
        $this->url = $url;
        $this->today = $today;
        $this->time = $time;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = 'Recuperação de Senha';

        if($this->password)
        {
            $text = "Sua Nova Senha";
        }

        return $this
            ->from('admin@beconnect.com.br')
            ->subject($text)
            ->view("emails.resetEmail");
    }
}
